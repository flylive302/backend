import { h, computed } from 'vue'
import DropdownAction from '@/components/ui/data-table-dropdown.vue'
import { ArrowUpDown } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import {Frame} from "@/types";
import {ColumnDef} from "@tanstack/vue-table";
import Avatar from '@/components/Avatar.vue';

export const columns: ColumnDef<Frame>[] = [
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
        accessorKey: 'animated_src',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Frame', h(ArrowUpDown)])
        },
        cell: ({ row }) => h(Avatar, {
            frameSrc: row.getValue('animated_src'),
            profileSrc: '/default-image.jpg',
            frameSize: 100,
            profileSize: 100,
            alt: 'Fly Live Frame',
            isAnimated: true,
            size: 4,
            profileDifference: 0.6,
            frameDifference: 1.3,
        }),
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
            const totalSeconds = row.getValue('valid_duration');
            const formattedDuration = computed(() => {
                // Work with a local copy so we don't modify the original value.
                let secondsLeft = totalSeconds

                // Calculate each time unit.
                const weeks   = Math.floor(secondsLeft / (7 * 24 * 3600))
                secondsLeft %= (7 * 24 * 3600)

                const days    = Math.floor(secondsLeft / (24 * 3600))
                secondsLeft %= (24 * 3600)

                const hours   = Math.floor(secondsLeft / 3600)
                secondsLeft %= 3600

                const minutes = Math.floor(secondsLeft / 60)
                const seconds = secondsLeft % 60

                // Build the formatted string. Only add parts that are non-zero.
                const parts = []
                if (weeks > 0) {
                    parts.push(`${weeks} w`)
                }
                if (days > 0) {
                    parts.push(`${days} d`)
                }
                if (hours > 0) {
                    parts.push(`${hours} h`)
                }
                if (minutes > 0) {
                    parts.push(`${minutes} m`)
                }
                if (seconds > 0) {
                    parts.push(`${seconds} s`)
                }

                // Join the parts with a space (or any separator you prefer)
                return parts.join(' ')
            })
            return h('div', { class: 'font-medium' }, formattedDuration.value)
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
