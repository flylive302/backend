import { h } from 'vue';
import { ArrowUpDown } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Frame } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import Avatar from '@/components/Avatar.vue';
import DropdownAction from '@/components/ui/data-table-dropdown.vue';
import ValidDuration from '@/components/ValidDuration.vue';

export const columns: ColumnDef<Frame>[] = [
    {
        id: 'select',
        header: ({ table }) =>
            h(Checkbox, {
                modelValue: table.getIsAllPageRowsSelected(),
                'onUpdate:modelValue': (value: boolean): void => table.toggleAllPageRowsSelected(value),
                ariaLabel: 'Select all'
            }),
        cell: ({ row }) =>
            h(Checkbox, {
                modelValue: row.getIsSelected(),
                'onUpdate:modelValue': (value: boolean): void => row.toggleSelected(value),
                ariaLabel: 'Select row'
            }),
        enableSorting: false,
        enableHiding: true
    },
    {
        accessorKey: 'animated_src',
        header: ({ column }) =>
            h(Button, {
                variant: 'ghost',
                onClick: (): void => column.toggleSorting(column.getIsSorted() === 'asc')
            }, () => ['Frame', h(ArrowUpDown)]),
        cell: ({ row }) => h(Avatar, {
            frameSrc: row.getValue<string>('animated_src') || '',
            profileSrc: '/default-image.jpg',
            frameSize: '100',
            profileSize: '100',
            alt: 'Fly Live Frame',
            isAnimated: true,
            size: 4,
            profileDifference: 0.6,
            frameDifference: 1.3
        })
    },
    {
        accessorKey: 'id',
        header: () => h('div', 'ID'),
        cell: ({ row }) => h('div', row.getValue<number>('id').toString())
    },
    {
        accessorKey: 'name',
        header: ({ column }) =>
            h(Button, {
                variant: 'ghost',
                onClick: (): void => column.toggleSorting(column.getIsSorted() === 'asc')
            }, () => ['Name', h(ArrowUpDown, { class: 'size-4' })]),
        cell: ({ row }) => h('div', row.getValue<string>('name'))
    },
    {
        accessorKey: 'price',
        header: ({ column }) =>
            h(
                Button, {
                    variant: 'ghost',
                    onClick: (): void => column.toggleSorting(column.getIsSorted() === 'asc')
                }, () => ['Price', h(ArrowUpDown, { class: 'size-4' })]
            ),

        cell: ({ row }) => {
            const amount = Number.parseFloat(row.getValue<string>('price'));
            const formatted = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount);

            return h('div', { class: 'font-medium' }, formatted);
        }
    },
    {
        accessorKey: 'valid_duration',
        header: () => h('div', 'Valid Duration'),
        cell: ({ row }) => {
            return h(ValidDuration, { totalSeconds: row.getValue<number>('valid_duration') });
        }
    },
    {
        id: 'actions',
        enableHiding: true,
        header: () => h('div', 'Actions'),
        cell: ({ row }) => {
            return h('div', { class: 'relative' }, [
                h(DropdownAction as any, {
                    item: row.original, // Provide the required "item" prop
                    onExpand: (): void => row.toggleExpanded?.()
                })
            ]);
        }
    }
];
