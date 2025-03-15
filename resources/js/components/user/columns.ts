import { h } from 'vue'
import DropdownAction from '@/components/ui/data-table-dropdown.vue'
import { ArrowUpDown, ChevronDown } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Avatar } from '@/components/ui/avatar';

export const columns: ColumnDef<Payment>[] = [
    {
        id: 'select',
        header: ({ table }) => h(Checkbox, {
            'modelValue': table.getIsAllPageRowsSelected(),
            'onUpdate:modelValue': (value: boolean) => table.toggleAllPageRowsSelected(value),
            'ariaLabel': 'Select all',
        }),
        cell: ({ row }) => h(Checkbox, {
            'modelValue': row.getIsSelected(),
            'onUpdate:modelValue': (value: boolean) => row.toggleSelected(value),
            'ariaLabel': 'Select row',
        }),
        enableSorting: true,
        enableHiding: true,
    },
    {
        id: 'avatar_img',
        header: ({ table }) => h('div', 'Avatar'),
        cell: ({ row }) => h(Avatar, {}, () => [
            h('AvatarImage', { src: row.getValue('avatar_img'), alt: '@unovue' }),
            h('AvatarFallback', {}, row.getValue('name').split(' ').map(n => n[0]).join(''))
        ]),
    },
    {
        accessorKey: 'id',
        header: () => h('div', 'id'),
        cell: ({ row }) => row.getValue('id'),
    },
    {
        accessorKey: 'name',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Name', h(ArrowUpDown, { class: 'ml-2 size-4' })])
        },
        cell: ({ row }) => h('div', row.getValue('name')),
    },
    {
        accessorKey: 'email',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Email', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'lowercase' }, row.getValue('email')),
    },
    {
        accessorKey: 'coin_balance',
        header: () => h('div', 'Coin Balance'),
        cell: ({ row }) => {
            const amount = Number.parseFloat(row.getValue('coin_balance'))
            const formatted = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            }).format(amount)

            return h('div', { class: 'font-medium' }, formatted)
        },
    },

    {
        id: 'actions',
        enableHiding: false,
        header: () => h('div', 'Actions'),
        cell: ({ row }) => {
            const item = row.original

            return h('div', { class: 'relative' }, h(DropdownAction, {
                item,
                onExpand: row.toggleExpanded,
            }))
        },
    },

]
