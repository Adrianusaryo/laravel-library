<template>
    <div ref="chartRef" style="width: 100%; height: 400px"></div>
</template>

<script setup>
import * as echarts from 'echarts'
import { ref, watch, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
    leaderboardUsers: {
        type: Array,
        default: () => [],
    },
})

const chartRef = ref(null)
let chart = null

function renderChart(data) {
    if (!chart) return
    if (!data || data.length === 0) {
        chart.clear()
        return
    }

    const names = data.map((user) => user.name)
    const points = data.map((user) => user.poin)

    const option = {
        title: {
            text: 'Leaderboard Pembaca Buku',
            left: 'center',
        },
        tooltip: {
            trigger: 'axis',
        },
        xAxis: {
            type: 'category',
            data: names,
        },
        yAxis: {
            type: 'value',
        },
        series: [
            {
                name: 'Jumlah Poin',
                type: 'bar',
                data: points,
                itemStyle: {
                    color: '#343a40',
                    borderRadius: [4, 4, 0, 0],
                },
            },
        ],
    }

    chart.setOption(option)
}

onMounted(() => {
    chart = echarts.init(chartRef.value)
    renderChart(props.leaderboardUsers)

    window.addEventListener('resize', () => {
        if (chart) chart.resize()
    })
})

onBeforeUnmount(() => {
    window.removeEventListener('resize', () => {
        if (chart) chart.resize()
    })
    if (chart) chart.dispose()
})

watch(
    () => props.leaderboardUsers,
    (newData) => {
        renderChart(newData)
    },
)
</script>
