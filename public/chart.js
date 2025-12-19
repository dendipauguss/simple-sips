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
        const stackChart = new Chart(sanksiPerBulanCanvas, {
            type: "line",
            data: {
                datasets: [
                    {
                        label: "Sudah Ditanggapi",
                        data: stackData,
                        borderColor: successColor,
                        backgroundColor: successColor,
                        stack: "combined",
                        type: "line",
                        fill: "start",
                        parsing: {
                            xAxisKey: "periode_label",
                            yAxisKey: "sudah"
                        }
                    },
                    {
                        label: "Belum Ditanggapi",
                        data: stackData,
                        borderColor: dangerColor,
                        backgroundColor: dangerColor,
                        stack: "combined",
                        fill: "start",
                        parsing: {
                            xAxisKey: "periode_label",
                            yAxisKey: "belum"
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
                            color: `rgb(${mutedColorRGB})`,
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
                            color: `rgb(${mutedColorRGB})`,
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
                            color: `rgb(${mutedColorRGB})`,
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
                        radius: 1,
                        hoverRadius: 3
                    },
                    line: {
                        tension: 0.25
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

    const pieCanvas = document.getElementById("_dm-pieChart");
    if (pieCanvas) {
        const labels = JSON.parse(pieCanvas.dataset.labels);
        const values = JSON.parse(pieCanvas.dataset.values);
        const pieChart = new Chart(
            pieCanvas, {
            type: "pie",
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                        primaryColor,
                        successColor,
                        warningColor,
                        dangerColor,
                        infoColor
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: "right",
                        labels: {
                            color: `rgb(${mutedColorRGB})`,
                            boxWidth: 12
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

    const pieCanvasSanksiPerPelanggaran = document.getElementById("sanksi_per_pelanggaran_chart");

    if (pieCanvasSanksiPerPelanggaran) {
        const labels = JSON.parse(pieCanvasSanksiPerPelanggaran.dataset.labels);
        const values = JSON.parse(pieCanvasSanksiPerPelanggaran.dataset.values);

        const pieChart = new Chart(
            pieCanvasSanksiPerPelanggaran, {
            type: "pie",
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    borderColor: "transparent",
                    backgroundColor: dynamicColors(),
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
});