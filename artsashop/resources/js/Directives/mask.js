import {masks} from '../Utils/masks'

export const vMask = {
    mounted(el, binding) {
        // v-mask funciona direto no <input> ou em um wrapper que contenha um <input>
        const input = el.tagName === 'INPUT' ? el : el.querySelector('input')
        if (!input) return

        const maskFn = masks[binding.value]
        if (!maskFn) {
            console.warn(`v-mask: máscara "${binding.value}" não existe`)
            return
        }

        const handler = () => {
            const masked = maskFn(input.value)

            if (input.value !== masked) {
                input.value = masked
                // avisa o v-model (e o useForm) do novo valor já formatado
                input.dispatchEvent(new Event('input', {bubbles: true}))
            }
        }

        input.addEventListener('input', handler)
        handler() // formata um valor que já venha preenchido

        el._maskCleanup = () => input.removeEventListener('input', handler)
    },

    unmounted(el) {
        el._maskCleanup?.()
    },
}
