import { h } from 'vue';
import { ArrowUpDown } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { ColumnDef } from '@tanstack/vue-table';
import { Badge } from '@/components/ui/badge';
import { Link } from '@inertiajs/vue3';
import { CoinRequests } from '@/types';

export const columns: ColumnDef<CoinRequests>[] = [
    // Checkbox for row selection
    {
        id: 'select',
        header: ({ table }) =>
            h(Checkbox, {
                'modelValue': table.getIsAllPageRowsSelected(),
                'onUpdate:modelValue': (value: boolean) => table.toggleAllPageRowsSelected(value),
                'ariaLabel': 'Select all'
            }),
        cell: ({ row }) =>
            h(Checkbox, {
                'modelValue': row.getIsSelected(),
                'onUpdate:modelValue': (value: boolean) => row.toggleSelected(value),
                'ariaLabel': 'Select row'
            }),
        enableSorting: false,
        enableHiding: false
    },

    // ID column
    {
        accessorKey: 'id',
        header: 'ID',
        cell: ({ row }) => h('div', row.getValue('id'))
    },

    // User ID column
    {
        accessorKey: 'user_id',
        header: 'User ID',
        cell: ({ row }) => h('div', row.getValue('user_id'))
    },

    // Requested From column
    {
        accessorKey: 'requested_from',
        header: 'Requested From',
        cell: ({ row }) => h('div', row.getValue('requested_from'))
    },

    // Amount column
    {
        accessorKey: 'amount',
        header: 'Amount',
        cell: ({ row }) => {
            const amount = Number(row.getValue('amount'));
            const formattedAmount = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount);

            return h('div', { class: 'font-medium' }, formattedAmount);
        }
    },

    // Status column with badges
    {
        accessorKey: 'status',
        header: 'Status',
        cell: ({ row }) => {
            const status = row.getValue('status') as number;
            const statusLabels: Record<number, string> = {
                1: 'Pending',
                2: 'Approved',
                3: 'Rejected'
            };

            const statusColors: Record<number, string> = {
                1: 'warning',
                2: 'success',
                3: 'destructive'
            };

            return h(
                Badge, { variant: statusColors[status] as any }, () => statusLabels[status] || 'Unknown'
            );
        }
    },

    // Type column
    {
        accessorKey: 'type',
        header: 'Type',
        cell: ({ row }) => {
            const type = row.getValue('type') as number;
            const typeLabels: Record<number, string> = {
                1: 'Cash',
                2: 'Credit'
            };

            const typeColors: Record<number, string> = {
                1: 'success',
                2: 'warning'
            };

            return h(
                Badge, { variant: typeColors[type] as any }, () => typeLabels[type] || 'Unknown'
            );
        }
    },

    // Credit days column
    {
        accessorKey: 'credit_days',
        header: 'Credit Days',
        cell: ({ row }) => {
            const creditDays = row.getValue('credit_days');
            return h('div', creditDays ?? '-');
        }
    },

    // Created At column
    {
        accessorKey: 'created_at',
        header: ({ column }) =>
            h(
                Button,
                {
                    variant: 'ghost',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc')
                },
                () => ['Created At', h(ArrowUpDown, { class: 'ml-2 size-4' })]
            ),
        cell: ({ row }) => h('div', new Date(row.getValue('created_at')).toLocaleString())
    },

    // Updated At column
    {
        accessorKey: 'updated_at',
        header: ({ column }) =>
            h(
                Button,
                {
                    variant: 'ghost',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc')
                },
                () => ['Updated At', h(ArrowUpDown, { class: 'ml-2 size-4' })]
            ),
        cell: ({ row }) => h('div', new Date(row.getValue('updated_at')).toLocaleString())
    },

    // Actions column
    {
        id: 'actions',
        enableSorting: false,
        enableHiding: false,
        header: () => h('div', 'Actions'),
        cell: ({ row }) => {
            const requestId = row.getValue('id');

            return h('div', { class: 'flex gap-2 items-center' }, [
                h(
                    Link,
                    {
                        href: route('coinRequest.show', { id: requestId }),
                        class: 'bg-primary px-2 py-1 rounded-md text-primary-foreground'
                    },
                    { default: () => 'View' }
                )
            ]);
        }
    }
];
