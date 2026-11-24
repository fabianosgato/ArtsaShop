
// Tipos
export interface Category {
    entityId: number
    parentId: number
    category: string
    slugKey: string
    level: number
    categoryPath: string
    isOpen: boolean
    hasProducts: boolean
    hasChildren: boolean
    children: Category[]
    isActive: boolean
}
