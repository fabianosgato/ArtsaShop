<script setup lang="ts">
import {ref, watch} from 'vue'
import {useForm} from '@inertiajs/vue3'
import {useUserLocation} from '../composables/useUserLocation'

import IconSpinner from '@/components/icons/IconSpinner.vue'

interface Estado {
    sigla: string
    nome: string
}

interface Cidade {
    id: number
    nome: string
}

interface UserLocation {
    country_code?: string
    country_name?: string
    state_code?: string
    state_name?: string
    city?: string
    postal_code?: string
    currency?: string
    locale?: string
    timezone?: string
}

const emit = defineEmits<{
    saved: [location: UserLocation]
}>()

const { location } = useUserLocation()

const estados = ref<Estado[]>([
    { sigla: 'AC', nome: 'Acre' }, { sigla: 'AL', nome: 'Alagoas' }, { sigla: 'AP', nome: 'Amapá' },
    { sigla: 'AM', nome: 'Amazonas' }, { sigla: 'BA', nome: 'Bahia' }, { sigla: 'CE', nome: 'Ceará' },
    { sigla: 'DF', nome: 'Distrito Federal' }, { sigla: 'ES', nome: 'Espírito Santo' },
    { sigla: 'GO', nome: 'Goiás' }, { sigla: 'MA', nome: 'Maranhão' }, { sigla: 'MT', nome: 'Mato Grosso' },
    { sigla: 'MS', nome: 'Mato Grosso do Sul' }, { sigla: 'MG', nome: 'Minas Gerais' },
    { sigla: 'PA', nome: 'Pará' }, { sigla: 'PB', nome: 'Paraíba' }, { sigla: 'PR', nome: 'Paraná' },
    { sigla: 'PE', nome: 'Pernambuco' }, { sigla: 'PI', nome: 'Piauí' }, { sigla: 'RJ', nome: 'Rio de Janeiro' },
    { sigla: 'RN', nome: 'Rio Grande do Norte' }, { sigla: 'RS', nome: 'Rio Grande do Sul' },
    { sigla: 'RO', nome: 'Rondônia' }, { sigla: 'RR', nome: 'Roraima' }, { sigla: 'SC', nome: 'Santa Catarina' },
    { sigla: 'SP', nome: 'São Paulo' }, { sigla: 'SE', nome: 'Sergipe' }, { sigla: 'TO', nome: 'Tocantins' },
])

const cidades = ref<Cidade[]>([])
const loadingCidades = ref(false)
const loadingCep = ref(false)

const form = useForm({
    cep: '',
    estado: '',
    cidade_id: '',
})

// Buscar cidades quando estado muda
watch(() => form.estado, async (uf) => {
    if (!uf) {
        cidades.value = []
        form.cidade_id = ''
        return
    }

    loadingCidades.value = true
    try {
        const resp = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${uf}/municipios`)
        const data = await resp.json()
        cidades.value = data.map((c: any) => ({ id: c.id, nome: c.nome })).sort((a, b) => a.nome.localeCompare(b.nome))
    } catch {
        cidades.value = []
    } finally {
        loadingCidades.value = false
    }
})

const buscarCep = async () => {
    const cep = form.cep.replace(/\D/g, '')
    if (cep.length !== 8) return

    loadingCep.value = true
    try {
        const resp = await fetch(`/api/cep/${cep}`)
        const data = await resp.json()

        if (!data.error) {
            form.estado = data.estado
            setTimeout(() => {
                const cidade = cidades.value.find(c => c.nome.toLowerCase() === data.cidade.toLowerCase())
                if (cidade) form.cidade_id = String(cidade.id)
            }, 100)
        }
    } finally {
        loadingCep.value = false
    }
}

const salvar = () => {
    const estado = estados.value.find(e => e.sigla === form.estado)
    const cidade = cidades.value.find(c => String(c.id) === form.cidade_id)

    const location = {
        country_code: 'BR',
        country_name: 'Brasil',
        state_code: form.estado,
        state_name: estado?.nome,
        city: cidade?.nome,
        postal_code: form.cep.replace(/\D/g, ''),
        currency: 'BRL',
        locale: 'pt_BR',
        timezone: 'America/Sao_Paulo',
    }

    emit('saved', location)
}

const formatCep = (value: string) => {
    const nums = value.replace(/\D/g, '').slice(0, 8)
    if (nums.length > 5) return `${nums.slice(0, 5)}-${nums.slice(5)}`
    return nums
}
</script>

<template>
    <div class="p-3 space-y-3">

        <!-- CEP -->
        <div>
            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">CEP</label>

            <!-- Input CEP -->
            <input
                type="text"
                v-model="form.cep"
                @input="form.cep = formatCep(form.cep)"
                @blur="buscarCep"
                placeholder="00000-000"
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                maxlength="9"
                :disabled="loadingCep"
            />

            <!-- Botão Buscar (embaixo, largura total) -->
            <button
                type="button"
                @click="buscarCep"
                :disabled="loadingCep || form.cep.replace(/\D/g, '').length !== 8"
                class="w-full mt-2 px-3 py-2 btn-forms transition whitespace-nowrap"
            >
                <span v-if="loadingCep" class="flex items-center justify-center gap-1">
                    <IconSpinner class="h-4 w-4 animate-spin" />
                    Buscando...
                </span>
                <span v-else>Buscar CEP</span>
            </button>

            <!-- Linha divisória -->
            <hr class="border-gray-100 my-3" />
        </div>

        <!-- Estado -->
        <div>
            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Estado *</label>
            <select
                v-model="form.estado"
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white"
                required
            >
                <option value="">Selecione</option>
                <option v-for="e in estados" :key="e.sigla" :value="e.sigla">{{ e.nome }} ({{ e.sigla }})</option>
            </select>
        </div>

        <!-- Cidade -->
        <div>
            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Cidade *</label>
            <select
                v-model="form.cidade_id"
                :disabled="!form.estado || loadingCidades"
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white"
                required
            >
                <option value="">Selecione</option>
                <option v-if="loadingCidades" disabled>Carregando...</option>
                <option v-for="c in cidades" :key="c.id" :value="String(c.id)">{{ c.nome }}</option>
            </select>
        </div>

        <!-- Salvar -->
        <button
            @click="salvar"
            :disabled="!form.estado || !form.cidade_id"
            class="w-full px-3 py-2 text-sm text-white bg-orange-600 rounded-lg hover:bg-orange-700 disabled:opacity-50 transition font-medium"
        >
            Salvar Localização
        </button>
    </div>
</template>
