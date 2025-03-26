import { h } from 'vue';
import DropdownAction from '@/components/ui/data-table-dropdown.vue';
import { ArrowUpDown } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Avatar } from '@/components/ui/avatar';
import { User } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import { Badge } from '@/components/ui/badge';
import { Link } from '@inertiajs/vue3';

export const columns: ColumnDef<User>[] = [
    {
        id: 'select',
        header: ({ table }) => h(Checkbox, {
            'modelValue': table.getIsAllPageRowsSelected(),
            'onUpdate:modelValue': (value: boolean) => table.toggleAllPageRowsSelected(value),
            'ariaLabel': 'Select all'
        }),
        cell: ({ row }) => h(Checkbox, {
            'modelValue': row.getIsSelected(),
            'onUpdate:modelValue': (value: boolean) => row.toggleSelected(value),
            'ariaLabel': 'Select row'
        }),
        enableSorting: true,
        enableHiding: true
    },
    {
        id: 'avatar_img',
        header: ({ table }) => h('div', 'Avatar'),
        cell: ({ row }) => h(Avatar, {}, () => [
            h('AvatarImage', { src: row.getValue('avatar_img'), alt: '@unovue' }),
            h('AvatarFallback', {}, (() => {
                const name = row.getValue('name') as string | undefined;
                return typeof name === 'string' ? name.split(' ').map(n => n[0]).join('') : '';
            })())
        ])
    },
    {
        accessorKey: 'id',
        header: () => h('div', 'id'),
        cell: ({ row }) => row.getValue('id')
    },
    {
        accessorKey: 'name',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc')
            }, () => ['Name', h(ArrowUpDown, { class: 'ml-2 size-4' })]);
        },
        cell: ({ row }) => h('div', row.getValue('name'))
    },
    {
        accessorKey: 'email',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc')
            }, () => ['Email', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })]);
        },
        cell: ({ row }) => h('div', { class: 'lowercase' }, row.getValue('email'))
    },
    {
        accessorKey: 'coin_balance',
        header: () => h('div', 'Coin Balance'),
        cell: ({ row }) => {
            const amount = Number.parseFloat(row.getValue('coin_balance'));
            const formatted = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount);

            return h('div', { class: 'font-medium' }, formatted);
        }
    },
    {
        accessorKey: 'roles',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc')
            }, () => ['Role', h(ArrowUpDown, { class: 'ml-2 size-4' })]);
        },
        cell: ({ row }) => {
            const roles = row.getValue('roles') as { name: string }[] | undefined;
            return h('div', { class: 'flex gap-2 max-w-[300px] max-h-[60px] overflow-x-auto' }, roles?.map(role =>
                h(Badge, role.name)
            ) || '');
        }
    },
    {
        id: 'actions',
        enableHiding: false,
        header: () => h('div', 'Actions'),
        cell: ({ row }) => {
            const item = row.original;

            return h('div', { class: 'flex gap-2 items-center' }, [
                h(Link, {
                    href: `/users/${row.getValue('id')}`,
                    class: 'bg-primary px-2 py-1 rounded-md text-primary-foreground'
                }, 'View'),
                h(DropdownAction as any, {
                    item: item, onExpand: () => row.toggleExpanded && row.toggleExpanded()
                })
            ]);
        }
    }

];
