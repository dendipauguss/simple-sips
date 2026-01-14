document.addEventListener("DOMContentLoaded", () => {

    // Color variables based on css variable.
    // ----------------------------------------------
    const _body = getComputedStyle(document.body);
    const primaryColor = _body.getPropertyValue("--bs-comp-active-bg");
    const successColor = _body.getPropertyValue("--bs-success");
    const infoColor = _body.getPropertyValue("--bs-info");
    const warningColor = _body.getPropertyValue("--bs-warning");
    const mutedColorRGB = _body.getPropertyValue("--bs-muted-color-rgb");
    const dangerColor = _body.getPropertyValue("--bs-danger");
    const lightColor = _body.getPropertyValue("--bs-light");
    const grayColor = "rgba( 180,180,180, .2 )";



    // Area Chart
    // ----------------------------------------------    
    const areaCanvas = document.getElementById("_dm-areaChart");
    if (areaCanvas) {
        const areaChart = new Chart(areaCanvas,
            {
                type: "line",
                data: {
                    datasets: [
                        {
                            label: "Upload Speed",
                            data: areaData,
                            borderColor: successColor,
                            backgroundColor: successColor,
                            type: "bar",
                            stack: "combined",
                            parsing: {
                                xAxisKey: "period",
                                yAxisKey: "up"
                            }
                        },
                        {
                            label: "Download Speed",
                            data: areaData,
                            borderColor: "transparent",
                            backgroundColor: grayColor,
                            stack: "combined",
                            parsing: {
                                xAxisKey: "period",
                                yAxisKey: "dl"
                            }
                        },
                    ]
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            align: "end",
                            labels: {
                                color: `rgb( ${mutedColorRGB})`,
                                boxWidth: 10,
                            }
                        },
                    },

                    interaction: {
                        mode: "index",
                        intersect: false,
                    },

                    scales: {
                        y: {
                            grid: {
                                borderWidth: 0,
                                color: `rgba( ${mutedColorRGB}, .07 )`
                            },
                            suggestedMax: 400,
                            ticks: {
                                font: { size: 11 },
                                color: `rgb( ${mutedColorRGB})`,
                                beginAtZero: false,
                                stepSize: 100
                            }
                        },
                        x: {
                            grid: {
                                borderWidth: 0,
                                drawOnChartArea: false
                            },
                            ticks: {
                                font: { size: 11 },
                                color: `rgb( ${mutedColorRGB})`,
                                autoSkip: true,
                                maxRotation: 0,
                                minRotation: 0,
                                maxTicksLimit: 7
                            }
                        }
                    },

                    // Dot width
                    radius: 1,

                    // Smooth lines
                    elements: {
                        line: {
                            tension: 0.5
                        }
                    }
                }
            }
        );
    }

    // Stack chart
    // ----------------------------------------------
    const sanksiPerBulanCanvas = document.getElementById("sanksi_per_bulan_chart");
    if (sanksiPerBulanCanvas) {
        const stackData = JSON.parse(sanksiPerBulanCanvas.dataset.stack);
        const ctx = sanksiPerBulanCanvas.getContext("2d");

        // Gradient hijau
        const gradientSuccess = ctx.createLinearGradient(0, 100, 0, 250);
        const gradientLight = ctx.createLinearGradient(0, 150, 0, 250);
        gradientSuccess.addColorStop(0, successColor);
        gradientSuccess.addColorStop(1, "rgba(159, 204, 46, 0.08)");
        gradientLight.addColorStop(0, lightColor);
        gradientLight.addColorStop(0.8, dangerColor);
        gradientLight.addColorStop(1, "rgba(225, 231, 240, 0.08)");

        const stackChart = new Chart(sanksiPerBulanCanvas, {
            type: "line",
            data: {
                datasets: [
                    {
                        label: "Sudah Ditanggapi",
                        data: stackData,
                        borderWidth: 0.5,
                        borderColor: successColor,
                        backgroundColor: gradientSuccess,
                        // stack: "combined",
                        // type: "line",
                        fill: "start",
                        parsing: {
                            xAxisKey: "periode_label",
                            yAxisKey: "sudah"
                        }
                    },
                    {
                        label: "Total Sanksi",
                        data: stackData,
                        borderWidth: 0.5,
                        borderColor: grayColor,
                        backgroundColor: gradientLight,
                        // stack: "combined",
                        fill: "start",
                        parsing: {
                            xAxisKey: "periode_label",
                            yAxisKey: "total_sanksi"
                        }
                    }
                ]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        align: "end",
                        labels: {
                            color: `#fff`,
                            boxWidth: 10,
                        }
                    },
                },

                interaction: {
                    mode: "index",
                    intersect: false,
                },

                scales: {
                    y: {
                        suggestedMax: 300,
                        grid: {
                            borderWidth: 0,
                            color: `rgba(${mutedColorRGB}, .07)`
                        },
                        ticks: {
                            font: { size: 11 },
                            color: `#fff`,
                            beginAtZero: false,
                            stepSize: 100
                        }
                    },
                    x: {
                        grid: {
                            borderWidth: 0,
                            drawOnChartArea: false
                        },
                        ticks: {
                            font: { size: 11 },
                            color: `#fff`,
                            autoSkip: true,
                            maxRotation: 0,
                            minRotation: 0,
                            maxTicksLimit: 7
                        }
                    }
                },

                // Dot width (line)
                // radius: 2,

                // Smooth lines
                elements: {
                    point: {
                        radius: 0,
                        hoverRadius: 3
                    },
                    line: {
                        tension: 0.4
                    }
                }
            }
        });
    }

    // Line Chart
    // ----------------------------------------------
    const lineData = [{ "elapsed": "2010", "value": 18 }, { "elapsed": "2011", "value": 24 }, { "elapsed": "2012", "value": 9 }, { "elapsed": "2013", "value": 12 }, { "elapsed": "2014", "value": 13 }, { "elapsed": "2015", "value": 22 }, { "elapsed": "2016", "value": 11 }, { "elapsed": "2017", "value": 26 }, { "elapsed": "2018", "value": 12 }, { "elapsed": "2019", "value": 19 }];
    const lineCanvas = document.getElementById("_dm-lineChart");
    if (lineCanvas) {
        const lineChart = new Chart(
            lineCanvas, {
            type: "line",
            data: {
                datasets: [
                    {
                        label: "Total order",
                        data: lineData,
                        borderWidth: 2,
                        borderColor: primaryColor,
                        backgroundColor: primaryColor,
                        parsing: {
                            xAxisKey: "elapsed",
                            yAxisKey: "value"
                        }
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        align: "end",
                        labels: {
                            color: `rgb( ${mutedColorRGB})`,
                            boxWidth: 10,
                        }
                    },
                },

                // Tooltip mode
                interaction: {
                    intersect: false,
                },

                scales: {
                    y: {
                        grid: {
                            borderWidth: 0,
                            color: `rgba( ${mutedColorRGB}, .07 )`
                        },
                        suggestedMax: 30,
                        ticks: {
                            font: { size: 11 },
                            color: `rgb( ${mutedColorRGB})`,
                            beginAtZero: false,
                            stepSize: 5
                        }
                    },
                    x: {
                        grid: {
                            borderWidth: 0,
                            drawOnChartArea: false
                        },
                        ticks: {
                            font: { size: 11 },
                            color: `rgb( ${mutedColorRGB})`,
                            autoSkip: true,
                            maxRotation: 0,
                            minRotation: 0,
                            maxTicksLimit: 7
                        }
                    }
                },

                elements: {
                    // Dot width
                    point: {
                        radius: 3,
                        hoverRadius: 5
                    },
                    // Smooth lines
                    line: {
                        tension: 0.2
                    }
                }
            }
        }
        );
    }

    // Bar Chart
    // ----------------------------------------------
    const barCanvas = document.getElementById("_dm-barChart");

    if (barCanvas) {
        const labels = JSON.parse(barCanvas.dataset.labels);
        const sudah = JSON.parse(barCanvas.dataset.sudah);
        const belum = JSON.parse(barCanvas.dataset.belum);
        const barChart = new Chart(
            barCanvas, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Sudah Ditanggapi",
                        data: sudah,
                        borderWidth: 2,
                        borderColor: successColor,
                        backgroundColor: successColor,
                        parsing: {
                            xAxisKey: "0",
                            yAxisKey: "1"
                        }
                    },
                    {
                        label: "Belum Ditanggapi",
                        data: belum,
                        borderWidth: 2,
                        borderColor: dangerColor,
                        backgroundColor: dangerColor,
                        parsing: {
                            xAxisKey: "0",
                            yAxisKey: "2"
                        }
                    }
                ]
            },

            options: {
                plugins: {
                    legend: {
                        display: true,
                        align: "end",
                        labels: {
                            color: `rgb( ${mutedColorRGB})`,
                            boxWidth: 10,
                        }
                    },
                    tooltip: {
                        position: "nearest"
                    }
                },

                interaction: {
                    mode: "index",
                    intersect: false,
                },

                scales: {
                    y: {
                        grid: {
                            borderWidth: 0,
                            color: `rgba( ${mutedColorRGB}, .07 )`
                        },
                        suggestedMax: 150,
                        ticks: {
                            font: { size: 11 },
                            color: `rgb( ${mutedColorRGB})`,
                            beginAtZero: false,
                            stepSize: 50
                        }
                    },
                    x: {
                        grid: {
                            borderWidth: 0,
                            drawOnChartArea: false
                        },
                        ticks: {
                            font: { size: 11 },
                            color: `rgb( ${mutedColorRGB})`,
                            autoSkip: true,
                            maxRotation: 10,
                            minRotation: 0,
                            maxTicksLimit: 11
                        }
                    }
                },

                elements: {
                    // Dot width
                    point: {
                        radius: 3,
                        hoverRadius: 5
                    },
                    // Smooth lines
                    line: {
                        tension: 0.2
                    }
                }
            }
        }
        );
    }

    // Doughnut Chart
    // ----------------------------------------------
    const circleData = [25, 35, 98];
    const doughnutCanvas = document.getElementById("_dm-doughnutChart");
    if (doughnutCanvas) {
        const doughnutChart = new Chart(
            doughnutCanvas, {
            type: "doughnut",
            data: {
                labels: ["Blue", "Orange", "Navy", "Green", "Gray"],
                datasets: [{
                    data: circleData,
                    borderColor: "transparent",
                    backgroundColor: [infoColor, warningColor, primaryColor, successColor, grayColor],
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: `rgb( ${mutedColorRGB})`,
                            boxWidth: 10,
                        }
                    },
                }
            }
        }
        );
    }

    // Pie Chart
    // ----------------------------------------------
    // const pieCanvas = document.getElementById("_dm-pieChart");
    // if (pieCanvas) {
    //     const statusData = JSON.parse(pieCanvas.dataset.status);

    //     const pieChart = new Chart(
    //         pieCanvas, {
    //         type: "pie",
    //         data: {
    //             labels: ["Belum Ditanggapi", "Sudah Ditanggapi"],
    //             datasets: [{
    //                 data: statusData,
    //                 borderColor: "transparent",
    //                 backgroundColor: [dangerColor, successColor],
    //             }]
    //         },
    //         options: {
    //             plugins: {
    //                 legend: {
    //                     display: true,
    //                     labels: {
    //                         color: `rgb( ${mutedColorRGB})`,
    //                         boxWidth: 10,
    //                     }
    //                 },
    //             }
    //         }
    //     }
    //     );
    // }    

    document.querySelectorAll(".donut-mini").forEach((el) => {
        const persen = parseFloat(el.dataset.persen);
        const nama = el.dataset.nama;
        const bgColors = generateRandomColors(nama.length);

        new Chart(el, {
            type: "doughnut",
            data: {
                datasets: [{
                    data: [persen, 100 - persen],
                    backgroundColor: [
                        bgColors,
                        `rgba(${mutedColorRGB}, .15)`
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                devicePixelRatio: window.devicePixelRatio || 2,
                cutout: "75%",
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            title: () => nama, // baris atas
                            label: (ctx) => {
                                if (ctx.dataIndex !== 0) return null;
                                return `${persen.toFixed(1)}%`;
                            }
                        }
                    }
                }
            },
            plugins: [{
                id: "centerText",
                beforeDraw(chart) {
                    const { ctx } = chart;
                    const meta = chart.getDatasetMeta(0).data[0];
                    if (!meta) return;
                    const centerX = meta.x;
                    const centerY = meta.y;

                    ctx.save();

                    // === PERSENTASE ===
                    ctx.font = "bold 16px sans-serif";
                    ctx.fillStyle = bgColors;
                    ctx.textAlign = "center";
                    ctx.textBaseline = "middle";
                    ctx.fillText(persen + "%", centerX, centerY - 8);

                    // === NAMA ===
                    ctx.font = "10px sans-serif";
                    ctx.fillStyle = `#fff`;

                    // potong teks jika kepanjangan
                    const maxWidth = 90;
                    const text = nama.length > 18 ? nama.substring(0, 18) + "…" : nama;

                    ctx.fillText(text, centerX, centerY + 10);

                    ctx.restore();
                }
            }]
        });
    });

    const sanksiPerBentukCanvas = document.getElementById("sanksi_per_bentuk_chart");
    if (sanksiPerBentukCanvas) {
        const labels = JSON.parse(sanksiPerBentukCanvas.dataset.labels);
        const values = JSON.parse(sanksiPerBentukCanvas.dataset.values);
        const bgColors = generateRandomColors(labels.length);

        new Chart(sanksiPerBentukCanvas, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Total Sanksi",
                        data: values,
                        backgroundColor: primaryColor,
                        borderColor: primaryColor,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'x', // 🔥 INI KUNCI MENYAMPING
                plugins: {
                    legend: {
                        display: true,
                        align: "end",
                        labels: {
                            color: `#fff`,
                            boxWidth: 10
                        }
                    },
                    tooltip: {
                        position: "nearest"
                    }
                },
                interaction: {
                    mode: "index",
                    intersect: false
                },
                scales: {
                    x: {
                        grid: {
                            color: `rgba(${mutedColorRGB}, .6)`,
                            borderWidth: 0
                        },
                        ticks: {
                            color: `#fff`,
                            stepSize: 5,
                            minRotation: 0,
                            maxRotation: 0
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: `#fff`,
                            font: { size: 11 },
                        }
                    }
                }
            }
        });
    }

    const pieCanvasSanksiPerPelanggaran = document.getElementById("sanksi_per_pelanggaran_chart");
    if (pieCanvasSanksiPerPelanggaran) {
        const labels = JSON.parse(pieCanvasSanksiPerPelanggaran.dataset.labels);
        const values = JSON.parse(pieCanvasSanksiPerPelanggaran.dataset.values);
        const bgColors = generateRandomColors(labels.length);

        const pieChart = new Chart(
            pieCanvasSanksiPerPelanggaran, {
            type: "pie",
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: bgColors,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: "right",
                        labels: {
                            color: `#fff`,
                            boxWidth: 10
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (ctx) {
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                const value = ctx.raw;
                                const percent = ((value / total) * 100).toFixed(1);
                                return `${ctx.label}: ${value} (${percent}%)`;
                            }
                        }
                    }
                }
            }
        }
        );
    }

    const topPelakuCanvas = document.getElementById("top_pelaku_chart");
    if (topPelakuCanvas) {
        const labels = JSON.parse(topPelakuCanvas.dataset.labels);
        const sudah = JSON.parse(topPelakuCanvas.dataset.sudah);
        const total = JSON.parse(topPelakuCanvas.dataset.total);

        new Chart(topPelakuCanvas, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Total Sanksi",
                        data: total,
                        backgroundColor: primaryColor,
                        borderColor: primaryColor,
                        borderWidth: 2
                    },
                    {
                        label: "Sudah Ditanggapi",
                        data: sudah,
                        backgroundColor: successColor,
                        borderColor: successColor,
                        borderWidth: 2
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y', // 🔥 INI KUNCI MENYAMPING
                plugins: {
                    legend: {
                        display: true,
                        align: "end",
                        labels: {
                            color: `#fff`,
                            boxWidth: 10
                        }
                    },
                    tooltip: {
                        position: "average"
                    }
                },
                interaction: {
                    mode: "index",
                    intersect: true
                },
                scales: {
                    x: {
                        grid: {
                            color: `rgba(${mutedColorRGB}, .6)`,
                            borderWidth: 0
                        },
                        ticks: {
                            color: `#fff`,
                            stepSize: 5,
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: `#fff`,
                            font: { size: 8 },
                        }
                    }
                }
            }
        });
    }

    const topJenisPelakuCanvas = document.getElementById("top_jenis_pelaku_chart");
    if (topJenisPelakuCanvas) {
        const labels = JSON.parse(topJenisPelakuCanvas.dataset.labels);
        const sudah = JSON.parse(topJenisPelakuCanvas.dataset.sudah);
        const total = JSON.parse(topJenisPelakuCanvas.dataset.total);

        new Chart(topJenisPelakuCanvas, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Total Sanksi",
                        data: total,
                        backgroundColor: primaryColor,
                        borderColor: primaryColor,
                        borderWidth: 2
                    },
                    {
                        label: "Sudah Ditanggapi",
                        data: sudah,
                        backgroundColor: successColor,
                        borderColor: successColor,
                        borderWidth: 2
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y', // 🔥 INI KUNCI MENYAMPING
                plugins: {
                    legend: {
                        display: true,
                        align: "end",
                        labels: {
                            color: `#fff`,
                            boxWidth: 10
                        }
                    },
                    tooltip: {
                        position: "average"
                    }
                },
                interaction: {
                    mode: "index",
                    intersect: true
                },
                scales: {
                    x: {
                        grid: {
                            color: `rgba(${mutedColorRGB}, .6)`,
                            borderWidth: 0
                        },
                        ticks: {
                            color: `#fff`,
                            stepSize: 5
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: `#fff`,
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
    }

    // Polar Area chart
    // ----------------------------------------------
    const polarCanvas = document.getElementById("_dm-polarAreaChart");
    if (polarCanvas) {
        const polarAreaChart = new Chart(
            polarCanvas, {
            type: "polarArea",
            data: {
                labels: ["Blue", "Orange", "Navy", "Green", "Gray"],
                datasets: [{
                    data: circleData,
                    borderColor: "transparent",
                    backgroundColor: [infoColor, warningColor, primaryColor, successColor, grayColor],
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: `rgb( ${mutedColorRGB})`,
                            boxWidth: 10,
                        }
                    },
                }
            }
        }
        );
    }

    // Bar Chart 1
    const barCanvas1 = document.getElementById("_dm-barChart-1");
    let barChart = null;
    let chartType = "bar";

    function loadChart(groupBy) {

        const showAll = document.getElementById('showAllLabel').checked;
        const isStacked = document.getElementById('stackedMode')?.checked ?? false;

        showLoading();

        fetch(`/dashboard/chart?group_by=${groupBy}&show_all=${showAll ? 1 : 0}`)
            .then(res => res.json())
            .then(data => {

                if (barChart) barChart.destroy();

                barChart = new Chart(barCanvas1, {
                    type: chartType,
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                label: "Sudah Ditanggapi",
                                data: data.sudah,
                                borderWidth: 2,
                                borderColor: successColor,
                                backgroundColor: successColor,
                            },
                            {
                                label: "Belum Ditanggapi",
                                data: data.belum,
                                borderWidth: 2,
                                borderColor: dangerColor,
                                backgroundColor: dangerColor,
                            }
                        ]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: true,
                                align: "end",
                                labels: {
                                    color: `rgb(${mutedColorRGB})`,
                                    boxWidth: 10,
                                }
                            },
                            tooltip: { position: "nearest" }
                        },
                        interaction: { mode: "index", intersect: false },
                        scales: {
                            y: {
                                stacked: isStacked,
                                grid: {
                                    borderWidth: 0,
                                    color: `rgba(${mutedColorRGB}, .07)`
                                },
                                suggestedMax: 150,
                                ticks: {
                                    font: { size: 11 },
                                    color: `rgb(${mutedColorRGB})`,
                                    beginAtZero: false,
                                    stepSize: 50
                                }
                            },
                            x: {
                                stacked: isStacked,
                                grid: {
                                    borderWidth: 0,
                                    drawOnChartArea: false
                                },
                                ticks: {
                                    font: { size: 11 },
                                    color: `rgb(${mutedColorRGB})`,
                                    autoSkip: true,
                                    maxRotation: 10,
                                    minRotation: 0,
                                    maxTicksLimit: 11
                                }
                            }
                        }
                    }
                });
            })
            .finally(() => hideLoading());
    }

    // default load
    loadChart('jenis_pelanggaran');

    document.getElementById('groupBy')
        .addEventListener('change', e => {
            loadChart(e.target.value);
        });

    document.getElementById('stackedMode')
        ?.addEventListener('change', () => {
            loadChart(document.getElementById('groupBy').value);
        });

    document.getElementById('showAllLabel')
        .addEventListener('change', () => {
            loadChart(document.getElementById('groupBy').value);
        });

    function showLoading() {
        document.getElementById('chartLoading').classList.remove('d-none');
    }

    function hideLoading() {
        document.getElementById('chartLoading').classList.add('d-none');
    }

    function generateRandomColors(total) {
        const colors = [];
        for (let i = 0; i < total; i++) {
            const r = Math.floor(Math.random() * 200);
            const g = Math.floor(Math.random() * 200);
            const b = Math.floor(Math.random() * 200);
            colors.push(`rgba(${r}, ${g}, ${b}, 0.8)`);
        }
        return colors;
    }

});