import { h } from 'vue'
import DropdownAction from '@/components/ui/data-table-dropdown.vue'
import { ArrowUpDown } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Avatar } from '@/components/ui/avatar';
import {Frames} from "@/types";
import {ColumnDef} from "@tanstack/vue-table";

export const columns: ColumnDef<Frames>[] = [
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
        id: 'static_src',
        header: ({ table }) => h('div', 'Frame'),
        cell: ({ row }) => h(Avatar, {}, () => [
            h('AvatarImage', { src: row.getValue('static_src'), alt: '@unovue' }),
            h('AvatarFallback', {}, (() => {
                const name = row.getValue('name') as string | undefined;
                return typeof name === 'string' ? name.split(' ').map(n => n[0]).join('') : '';
            })())
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
        accessorKey: 'price',
        header: () => h('div', 'Price'),
        cell: ({ row }) => {
            const amount = Number.parseFloat(row.getValue('price'))
            const formatted = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            }).format(amount)

            return h('div', { class: 'font-medium' }, formatted)
        },
    },
    {
        accessorKey: 'valid_duration',
        header: () => h('div', 'Valid Duration'),
        cell: ({ row }) => {
            return h('div', { class: 'font-medium' }, Number.parseFloat(row.getValue('valid_duration')))
        },
    },

    {
        id: 'actions',
        enableHiding: false,
        header: () => h('div', 'Actions'),
        cell: ({ row }) => {
            const item = row.original

            return h('div', { class: 'relative' }, [h(DropdownAction as any, {
                item: item,
                onExpand: () => row.toggleExpanded && row.toggleExpanded(),
            })])
        },
    },

]
