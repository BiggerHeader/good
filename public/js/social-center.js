$(function () {
    //初始化:页面内的active标签及数据
    function GetQueryString(name){
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
        var r = window.location.search.substr(1).match(reg);
        if (r!=null) return (r[2]);
        return 0;//默认为第0个标签
    }
    var sname = GetQueryString("active");

    var snameValue = decodeURIComponent(sname);
    var jqueryStr = $(".step:eq("+snameValue+")");
    jqueryStr.addClass("active");

    $(".step:not(.active)").click(function () {
        parent.reloadTab($(this).attr("data-href"));//加载新的tab页
    });

    //点击收藏事件
    $('.favor-link').click(function(){
        html2canvas(document.body, {
            onrendered: function(canvas) {
                var favorIcon = canvas.toDataURL();//图片的base64
                var favorTitle = $(window.parent.document).find('li.tabs-selected').find('.tabs-title').html();
                var favorUrl = window.location.href;
                console.log(favorIcon, favorTitle, favorUrl);
                var contents = '成功添加至『&nbsp;<span class="catch">我的收藏</span>&nbsp;』！';
                var $favorModal = '<div class="ok-mask" >' +
                    '<div class="ok-dialog">' +
                    '<h1 class="sucess-tip">'+contents+'</h1>' +
                    '</div>' +
                    '</div>';
                //发ajax啦
                $.ajax({
                    type: "post",
                    url: '/admin/my_collect/save_collect',
                    dataType: "json",
                    data:{favorIcon:favorIcon,favorTitle:favorTitle,favorUrl:favorUrl},
                    success: function (data) {
                        if( data.code == 200 ){
                            $('body').append($favorModal);
                            setTimeout('$(".ok-mask").remove();',2000);
                        }
                    }
                });
            }
        });
    });

});
    var option = {
        // 默认色板
        //color: [
        //    '#1790cf', '#1bb2d8', '#99d2dd', '#88b0bb',
        //    '#1c7099', '#038cc4', '#75abd0', '#afd6dd'
        //],
        color: [
            '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80',
            '#8d98b3','#e5cf0d','#97b552','#95706d','#dc69aa',
            '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
            '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
        ],
        title: {
            text: '',
            subtext: ''
        },
        tooltip: {
            trigger: 'item'
        },
        toolbox: {
            show: false
        },
        calculable: false
    };

    function test(id) {
        if(!document.getElementById(id))return;
        var testChart = echarts.init(document.getElementById(id));
        var testOption = {};
        $.extend(true, testOption, option);
        testOption.tooltip = {
            trigger: 'axis'
        };
        testOption.color = [
            '#2ec7c9','#c14089','#588dd5','#e5cf0d','#d87a80',
            '#8d98b3','#97b552','#95706d','#dc69aa',
            '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
            '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
        ];
        // testOption.dataZoom = {
        //     show: false,
        //     realtime : true,
        //     start : 30,
        //     end : 60,
        //     height:25
        // };
        testOption.legend = {
            data: testLegendData
        };
        testOption.grid =  {
            y2: 80
        };
        testOption.xAxis = [
            {
                type: 'category',
                boundaryGap : false,
                data:testXData,
                splitLine:false
                //axisLabel:{
                //    interval:6//x轴隔六个显示
                //}
            }
        ];
        testOption.yAxis = [
            {type: 'value'}
        ];
        testOption.series=[];
        for(var i=0;i<testLegendData.length;i++){
            var eachSeries = {};
            eachSeries.name = testLegendData[i];
            eachSeries.type = 'line';
            eachSeries.symbol= 'none';
            eachSeries.data = testYData[i];
            testOption.series.push(eachSeries);
        }
        testChart.setOption(testOption);
        window.addEventListener("resize", function () {
            testChart.resize();
        });
    }

    function test1(id) {
        if(!document.getElementById(id))return;
        var test1Chart = echarts.init(document.getElementById(id));
        var test1Option = {};
        $.extend(true, test1Option, option);

        test1Option.tooltip = {
            trigger: 'axis'
        };
        test1Option.legend = {
            data:test1LegendData
        };

        test1Option.calculable = true;
        test1Option.xAxis = [
            {
                type: 'category',
                data: test1XData
            }
        ];
        test1Option.yAxis = [
            {
                type: 'value'
            }
        ];
        test1Option.series=[];
        var baseSeries = {
            type: 'bar'
/*            markPoint: {
                data: [
                    {type: 'max', name: '最大值'},
                    {type: 'min', name: '最小值'}
                ]
            },
            markLine: {
                data: [
                    {type: 'average', name: '平均值'}
                ]
            }*/
        };
        for(var i=0;i<test1LegendData.length;i++){
            var eachSeries = {};
            $.extend(true, eachSeries, baseSeries);
            eachSeries.name = test1LegendData[i];
            eachSeries.data = test1YData[i];
            test1Option.series.push(eachSeries);
        }
        test1Chart.setOption(test1Option);
        window.addEventListener("resize", function () {
            test1Chart.resize();
        });
    }

        function test1_one(id) {
            if(!document.getElementById(id))return;
            var test1Chart = echarts.init(document.getElementById(id));
            var test1Option = {};
            $.extend(true, test1Option, option);

            test1Option.tooltip = {
                trigger: 'axis'
            };
            test1Option.legend = {
                data:test1LegendData
            };
            test1Option.toolbox= {
                show : true,
                feature : {
                    dataView : {show: true, readOnly: false}
                }
            };

            test1Option.calculable = true;
            test1Option.xAxis = [
                {
                    type: 'category',
                    data: test1XData
                }
            ];
            test1Option.yAxis = [
                {
                    type: 'value'
                }
            ];
            test1Option.series=[];
            var baseSeries = {
                type: 'bar',
                //stack:'sum'
            };
            for(var i=0;i<test1LegendData.length;i++){
                var eachSeries = {};
                $.extend(true, eachSeries, baseSeries);
                eachSeries.name = test1LegendData[i];
                eachSeries.data = test1YData[i];
                test1Option.series.push(eachSeries);
            }
            test1Chart.setOption(test1Option);
            window.addEventListener("resize", function () {
                test1Chart.resize();
            });
        }

    function test2(id) {
        if(!document.getElementById(id))return;
        var test2Chart = echarts.init(document.getElementById(id));
        var test2Option = {};
        $.extend(true, test2Option, option);
        test2Option.tooltip = {
            trigger: 'axis',
            axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        };
        test2Option.legend = {
            data:test2LegendData
        };
        test2Option.calculable = true;
        test2Option.xAxis = [
            {
                type: 'category',
                data:test2XData
            }
        ];
        test2Option.yAxis = [
            {
                type: 'value'
            }
        ];
        test2Option.series=[];

        for(var i=0;i<test2LegendData.length;i++){
            var eachSeries = {};
            eachSeries.name = test2LegendData[i];
            eachSeries.type = 'bar';
            if(test2Class[i])eachSeries.stack = test2Class[i];
            eachSeries.data = test2YData[i];
            test2Option.series.push(eachSeries);
        }

        test2Chart.setOption(test2Option);
        window.addEventListener("resize", function () {
            test2Chart.resize();
        });
    }

    function test3(id) {
        if(!document.getElementById(id))return;
        var test3Chart = echarts.init(document.getElementById(id));
        var test3Option = {};
        $.extend(true, test3Option, option);

        test3Option.tooltip = {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        };
        test3Option.legend = {
            orient: 'vertical',
            x: 'left',
            data: test3LegendData
        };
        test3Option.series = [
            {
                name: test3NameData[0],
                type: 'pie',
                selectedMode: 'single',
                radius: [0, 70],
                x: '20%',
                width: '40%',
                funnelAlign: 'right',

                itemStyle: {
                    normal: {
                        label: {
                            position: 'inner'
                        },
                        labelLine: {
                            show: false
                        }
                    }
                },
                data: test3Data[0]
            },
            {
                name: test3NameData[1],
                type: 'pie',
                radius: [100, 140],
                x: '60%',
                width: '35%',
                funnelAlign: 'left',
                data:test3Data[1]
            }
        ];
        test3Chart.setOption(test3Option);
        window.addEventListener("resize", function () {
            test3Chart.resize();
        });
    }

    function test4(id) {
        if(!document.getElementById(id))return;
        var test4Chart = echarts.init(document.getElementById(id));
        var test4Option = {};
        $.extend(true, test4Option, option);

        test4Option.tooltip = {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        };
        test4Option.legend = {
            orient: 'vertical',
            x: 'right',
            data: test4LegendData
        };
        test4Option.calculable = true;
        test4Option.series = [
            {
                name:test4NameData[0] ,
                type: 'pie',
                radius: '75%',//半径
                data:test4Data[0]
            }
        ];
        test4Chart.setOption(test4Option);
        window.addEventListener("resize", function () {
            test4Chart.resize();
        });
        //联动图标：点击事件
        //if($('.ld-table')){
        //    test4Chart.on('click', getNewGraph);
        //}
        //function getNewGraph(){
        //    //alert("点击事件！")
        //    console.log(this.dom.textContent.split(" ")[1]);
        //    //return false;
        //}
    }
    function test4_new(id) {
        if(!document.getElementById(id))return;
        var test4Chart = echarts.init(document.getElementById(id));
        var test4Option = {};
        $.extend(true, test4Option, option);
        test4Option.title = {
            text:test4NameData,
            x:'center'
        };
        test4Option.tooltip = {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        };
        test4Option.legend = {
            orient: 'horizontal',
            x: 'center',
            y:'bottom',
            data: test4LegendData
        };
        test4Option.calculable = true;
        test4Option.series = [
            {
                name:test4NameData[0] ,
                type: 'pie',
                radius: '75%',//半径
                itemStyle : {
                    normal : {
                        label : {
                            position : 'outer',
                            formatter : function (params) {
                                return params.name+"\n"+(params.percent - 0).toFixed(0) + '%'
                            }
                        },
                        labelLine : {
                            show :true
                        }
                    },
                    emphasis : {
                        label : {
                            show : true,
                            position : 'inner',
                            formatter : "{b}\n{d}%"
                        }
                    }
                },
                data:test4Data[0]
            }
        ];
        test4Chart.setOption(test4Option);
        window.addEventListener("resize", function () {
            test4Chart.resize();
        });
        //联动图标：点击事件
        if($('.ld-table')){
            test4Chart.on('click', getNewGraph);
        }
        //function getNewGraph(){
        //    //alert("点击事件！")
        //    //return this.dom.textContent.split(" ")[1];
        //    //click_area = this.dom.textContent.split(" ")[1];
        //    //return false;
        //}
    }
        function test4_new_yy(id) {
        if(!document.getElementById(id))return;
        var test4Chart = echarts.init(document.getElementById(id));
        var test4Option = {};
        $.extend(true, test4Option, option);
        test4Option.title = {
            text:test4NameData,
            x:'center'
        };
        test4Option.tooltip = {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        };
        test4Option.legend = {
            orient: 'horizontal',
            x: 'center',
            y:'bottom',
            data: test4LegendData
        };
        test4Option.toolbox = {
            show:true,
            feature  : {
                dataView : {show: true}
            }
        };
        test4Option.calculable = true;
        test4Option.series = [
            {
                name:test4NameData[0] ,
                type: 'pie',
                radius: '48%',//半径
                itemStyle : {
                    normal : {
                        label : {
                            position : 'outer',
                            formatter : function (params) {
                                return params.name+"\n"+(params.percent - 0).toFixed(0) + '%'
                            }
                        },
                        labelLine : {
                            show :true
                        }
                    },
                    emphasis : {
                        label : {
                            show : true,
                            position : 'inner',
                            formatter : "{b}\n{d}%"
                        }
                    }
                },
                data:test4Data[0]
            }
        ];
        test4Chart.setOption(test4Option);
        window.addEventListener("resize", function () {
            test4Chart.resize();
        });
        //联动图标：点击事件
        if($('.ld-table')){
            test4Chart.on('click', getNewGraph);
        }
    }
    function test5(id) {
        if(!document.getElementById(id))return;
        var test5Chart = echarts.init(document.getElementById(id));
        var test5Option = {};
        $.extend(true, test5Option, option);
        var labelFromatter = {
            normal : {
                label : {
                    formatter : function (params){
                        return 100 - params.value + '%'
                    },
                    textStyle: {
                        baseline : 'top'
                    }
                }
            }
        };

        var radius = [40, 70];
        test5Option = {
            color: [
                '#1790cf', '#1bb2d8', '#99d2dd', '#88b0bb',
                '#1c7099', '#038cc4', '#75abd0', '#afd6dd'
            ],
            legend: {
                orient: 'vertical',
                x: 'left',
                data:test5LegendData
            },
            title : {
                text: '',
                subtext: '',
                x: ''
            },
            toolbox: {
                show : false
            },
            series : [
                {
                    type : 'pie',
                    center : ['35%', '25%'],
                    radius : radius,
                    x: '0%', // for funnel
                    itemStyle : labelFromatter,
                    data :test5Data[0]
                },
                {
                    type : 'pie',
                    center : ['35%', '75%'],
                    radius : radius,
                    x:'50%', // for funnel
                    itemStyle : labelFromatter,
                    data : test5Data[1]
                },
                {
                    type : 'pie',
                    center : ['65%', '25%'],
                    radius : radius,
                    x:'0%', // for funnel
                    y:'55%',
                    itemStyle : labelFromatter,
                    data :test5Data[2]
                },
                {
                    type : 'pie',
                    center : ['65%', '75%'],
                    radius : radius,
                    y:'55%',
                    x:'50%', // for funnel
                    itemStyle : labelFromatter,
                    data :test5Data[3]
                }
            ]
        };
        test5Chart.setOption(test5Option);
        window.addEventListener("resize", function () {
            test5Chart.resize();
        });
    }
    function test6(id,titlename) {
        console.log(test6LegendData);
        if(!document.getElementById(id))return;
        var test6Chart = echarts.init(document.getElementById(id));
        var test6Option = {};
        $.extend(true, test6Option, option);
        test6Option.tooltip.trigger= 'axis';
        test6Option.legend = {
            y:'bottom',
            data: test6LegendData
        };
        test6Option.title = {
            x:'center',
            y:'top',
            text: '活跃时长在'+titlename+'分钟用户消息类型'
        };
        test6Option.grid =  {
            y2: 80
        };
        test6Option.xAxis = [
            {
                type : 'category',

                boundaryGap: true,
                data : test6XData,
                splitLine:false
            }
        ];
        test6Option.yAxis =  [
            {
                type : 'value',
                position: 'left'
            },
            {
                type : 'value'
            }
        ];
        test6Option.series= [
            {
                name: test6LegendData[0],
                type: 'bar',
                stack: 'msg',
                data:test6Data[0],
                barCategoryGap:'40%'
            },
            {
                name: test6LegendData[1],
                type: 'bar',
                stack: 'msg',
                barCategoryGap:'40%',
                data:test6Data[1]
            },
            {
                name: test6LegendData[2],
                type: 'bar',
                stack: 'msg',
                barCategoryGap:'40%',
                data:test6Data[2]
            },
            {
                name: test6LegendData[3],
                type: 'bar',
                stack: 'msg',
                barCategoryGap:'40%',
                data:test6Data[3]
            },
            {
                name: test6LegendData[4],
                type: 'bar',
                stack: 'msg',
                barCategoryGap:'40%',
                data:test6Data[4]
            },
            {
                name: test6LegendData[5],
                type: 'bar',
                stack: 'msg',
                barCategoryGap:'40%',
                data:test6Data[5]
            },
            {
                name:test6LegendData[6],
                type: 'line',
                yAxisIndex: 1,
                data:test6Data[6],
                itemStyle : {
                    normal : {
                        lineStyle : {
                            color:"#6E6E6E"
                        }
                    }
                }
            }
        ];
        test6Chart.setOption(test6Option);
        window.addEventListener("resize", function () {
            test6Chart.resize();
        });
    }
function test7(id) {
    console.log(test7LegendData);
    if(!document.getElementById(id))return;
    var test7Chart = echarts.init(document.getElementById(id));
    var test7Option = {};
    $.extend(true, test7Option, option);
    test7Option.tooltip.trigger= 'axis';
    test7Option.legend = {
        data: test7LegendData
    };
    test7Option.grid =  {
        y2: 80
    };
    test7Option.xAxis = [
        {
            type : 'category',

            boundaryGap: true,
            data : test7XData,
            splitLine:false
        }
    ];
    test7Option.yAxis =  [
        {
            type : 'value',
            position: 'left'
        },
        {
            type : 'value'
        }
    ];
    test7Option.series= [
        {
            name: test7LegendData[1],
            type: 'bar',
            stack: 'msg',
            data:test7YData[1],
            barCategoryGap:'40%'
        },
        {
            name: test7LegendData[2],
            type: 'bar',
            stack: 'msg1',
            barCategoryGap:'40%',
            //yAxisIndex: 1,
            data:test7YData[2]
        },
        {
            name:test7LegendData[0],
            type: 'line',
            data:test7YData[0],
            itemStyle : {
                normal : {
                    lineStyle : {
                        color:"#6E6E6E"
                    }
                }
            }
        }
    ];
    test7Chart.setOption(test7Option);
    window.addEventListener("resize", function () {
        test7Chart.resize();
    });
}
function test8(id) {
    if(!document.getElementById(id))return;
    var test3Chart = echarts.init(document.getElementById(id));
    var test3Option = {};
    $.extend(true, test3Option, option);

    test3Option.tooltip = {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    };
    test3Option.legend = {
        orient: 'vertical',
        x: 'left',
        data: test5LegendData
    };
    test3Option.toolbox={
        show : true,
            feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            magicType : {
                show: true,
                    type: ['pie', 'funnel']
            },
            restore : {show: true},
            saveAsImage : {show: true}
        }
    };
    test3Option.calculable=true;
    test3Option.series = [
        {
            name:'半径模式',
            type:'pie',
            radius : [20, 130],
            // center : ['25%', 200],
            roseType : 'radius',
            //width: '40%',       // for funnel
            // max: 40,            // for funnel
            itemStyle : {
                normal : {
                    label : {
                        position : 'outer',
                        formatter : function (params) {
                            return params.name+"\n"+(params.percent - 0).toFixed(0) + '%'
                        }
                    },
                    labelLine : {
                        show :true
                    }
                },
                emphasis : {
                    label : {
                        show : true,
                        position : 'inner',
                        formatter : "{b}\n{d}%"
                    }
                }

            },
            data:test5Data
        }
    ];
    test3Chart.setOption(test3Option);
    window.addEventListener("resize", function () {
        test3Chart.resize();
    });
}
function test9(id) {
    if(!document.getElementById(id))return;
    var test3Chart = echarts.init(document.getElementById(id));
    var test3Option = {};
    $.extend(true, test3Option, option);

    test3Option.tooltip = {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    };
    test3Option.legend = {
        orient: 'vertical',
        x: 'left',
        data: test5LegendData
    };
    test3Option.calculable=true;
    test3Option.series = [
        {
            name:test5NameData,
            type:'pie',
            radius : [80, 160],

            // for funnel
            x: '60%',
            width: '35%',
            funnelAlign: 'left',
            max: 1048,

            data:test5Data
        }
    ];
    test3Chart.setOption(test3Option);
    window.addEventListener("resize", function () {
        test3Chart.resize();
    });
}

//双柱（比较柱）
function test10(id) {
    console.log(test10LegendData);
    if(!document.getElementById(id))return;
    var test10Chart = echarts.init(document.getElementById(id));
    var test100Option = {};
    $.extend(true, test100Option, option);
    test100Option.tooltip.trigger= 'axis';
    test100Option.legend = {
        data: test10LegendData
    };
    test100Option.grid =  {
        y2: 80
    };
    test100Option.xAxis = [
        {
            type : 'category',
            boundaryGap: true,
            data : test10XData,
            splitLine:false
        }
    ];
    test100Option.yAxis =  [
        {
            type : 'value',
        }
    ];
    test100Option.series= [
        {
            name: test10LegendData[0],
            type: 'bar',
            stack: 'msg',
            data:test10YData[0],
            barCategoryGap:'40%'
        },
        {
            name: test10LegendData[1],
            type: 'bar',
            stack: 'msg1',
            barCategoryGap:'40%',
            data:test10YData[1]
        }
    ];
    test10Chart.setOption(test100Option);
    window.addEventListener("resize", function () {
        test10Chart.resize();
    });
}

//单柱、单线
function test11(id) {
    console.log(test11LegendData);
    if(!document.getElementById(id))return;
    var test11Chart = echarts.init(document.getElementById(id));
    var test110Option = {};
    $.extend(true, test110Option, option);
    test110Option.tooltip.trigger= 'axis';
    test110Option.legend = {
        data: test11LegendData
    };
    test110Option.grid =  {
        y2: 80
    };
    test110Option.xAxis = [
        {
            type : 'category',
            boundaryGap: true,
            data : test11XData,
            splitLine:false
        }
    ];
    test110Option.yAxis =  [
        {
            type : 'value',
        },
        {
            type: 'value',
            min: 0,
            max: 50
        }
    ];
    test110Option.series= [
        {
            name: test11LegendData[0],
            type: 'bar',
            stack: 'msg',
            barCategoryGap:'40%',
            data:test11YData[0]
        },
        {
            name:test11LegendData[1],
            type: 'line',
            yAxisIndex: 1,
            data:test11YData[1],
            itemStyle : {
                normal : {
                    lineStyle : {
                        color:"#6E6E6E"
                    }
                }
            }
        }
    ];
    test11Chart.setOption(test110Option);
    window.addEventListener("resize", function () {
        test11Chart.resize();
    });
}

//单柱、单线 (右侧没高度限制)
function test12(id) {
    console.log(test12LegendData);
    if(!document.getElementById(id))return;
    var test12Chart = echarts.init(document.getElementById(id));
    var test120Option = {};
    $.extend(true, test120Option, option);
    test120Option.tooltip.trigger= 'axis';
    test120Option.legend = {
        data: test12LegendData
    };
    test120Option.toolbox = {
            show : true,
            feature : {
                dataView : {show: true, readOnly: false},
            }
        };
    
    test120Option.grid =  {
        y2: 80
    };
    test120Option.xAxis = [
        {
            type : 'category',
            boundaryGap: true,
            data : test12XData,
            splitLine:false
        }
    ];
    test120Option.yAxis =  [
        {
            type : 'value',
            name:lable12[0],
            axisLabel : {
                formatter: '{value} 人'
            }
        },
        {
            type: 'value',
            name:lable12[1],
            axisLabel : {
                formatter: '{value} 元'
            }
        }
    ];
    test120Option.series= [
        {
            name: test12LegendData[0],
            type: 'bar',
            stack: 'msg',
            barCategoryGap:'40%',
            data:test12YData[0],
            smooth:'true',
        },
        {
            name:test12LegendData[1],
            type: 'line',
            yAxisIndex: 1,
            data:test12YData[1],
            smooth:'true',
        }
    ];
    test12Chart.setOption(test120Option);
    window.addEventListener("resize", function () {
        test12Chart.resize();
    });
}

//两根线 (右侧没高度限制)
function test13(id) {
    console.log(test13LegendData);
    if(!document.getElementById(id))return;
    var test13Chart = echarts.init(document.getElementById(id));
    var test130Option = {};
    $.extend(true, test130Option, option);
    test130Option.tooltip.trigger= 'axis';
    test130Option.legend = {
        data: test13LegendData
    };
    test130Option.toolbox = {
            show : true,
            feature : {
                dataView : {show: true, readOnly: false},
            }
        };
    
    test130Option.grid =  {
        y2: 80
    };
    test130Option.xAxis = [
        {
            type : 'category',
            boundaryGap: true,
            data : test13XData,
            splitLine:false
        }
    ];
    test130Option.yAxis =  [
        {
            type : 'value',
            name:lable13[0],
            axisLabel : {
                formatter: '{value} 人'
            }
        },
        {
            type: 'value',
            name:lable13[1],
            axisLabel : {
                formatter: '{value} 元'
            }
        }
    ];
    test130Option.series= [
        {
            name: test13LegendData[0],
            type: 'line',
            data:test13YData[0],
            smooth:'true',
        },
        {
            name:test13LegendData[1],
            type: 'line',
            yAxisIndex: 1,
            data:test13YData[1],
            smooth:'true',
        }
    ];
    test13Chart.setOption(test130Option);
    window.addEventListener("resize", function () {
        test13Chart.resize();
    });
}



function pic_tree(id){
    if(!document.getElementById(id))return;
    var pic_tree_chart = echarts.init(document.getElementById(id));
    var pic_tree_option = {
        tooltip : {
            trigger: 'item',
            formatter: "{b}: {c}"
        },
        calculable : false,
        series : [
            {
                name:'树图',
                type:'tree',
                orient: 'horizontal',  // vertical horizontal
                rootLocation: {x: 80, y: '50%'}, // 根节点位置  {x: 'center',y: 10}
                nodePadding: 20,
                layerPadding:180,
                symbol: 'circle',
                symbolSize: 20,
                itemStyle: {
                    normal: {
                        color: '#afd6dd',
                        label: {
                            show: true,
                            position: 'left',
                            textStyle: {
                                color: '#000',
                                fontSize: 14
                                //fontWeight:  'bolder'
                            }
                        },
                        lineStyle: {
                            color: '#afd6dd',
                            width: 1,
                            type: 'broken' // 'curve'|'broken'|'solid'|'dotted'|'dashed'
                        }
                    },
                    emphasis: {
                        label: {
                            show:false
                        },
                        borderWidth: 0
                    }
                },
                data: pic_tree_data
            }
        ]
    };
    pic_tree_chart.setOption(pic_tree_option);
    window.addEventListener("resize", function () {
        pic_tree_chart.resize();
    });
    pic_tree_chart.on('click', getNewGraph);
}
function pic_tree_sub(id){
    if(!document.getElementById(id))return;
    var pic_tree_chart = echarts.init(document.getElementById(id));
    var pic_tree_option = {
        tooltip : {
            trigger: 'item',
            formatter: "{b}: {c}"
        },
        calculable : false,
        series : [
            {
                name:'树图',
                type:'tree',
                orient: 'horizontal',  // vertical horizontal
                rootLocation: {x: 40, y: '50%'}, // 根节点位置  {x: 'center',y: 10}
                nodePadding: 50,
                layerPadding:115,
                symbol: 'circle',
                symbolSize: 20,
                itemStyle: {
                    normal: {
                        color: '#afd6dd',
                        label: {
                            show: true,
                            position: 'top',
                            textStyle: {
                                color: '#000',
                                fontSize: 14
                                //fontWeight:  'bolder'
                            }
                        },
                        lineStyle: {
                            color: '#afd6dd',
                            width: 1,
                            type: 'broken' // 'curve'|'broken'|'solid'|'dotted'|'dashed'
                        }
                    },
                    emphasis: {
                        label: {
                            show:false
                        },
                        borderWidth: 0
                    }
                },
                data: [
                    {
                        name: pic_tree_data[0].name,
                        value: pic_tree_data[0].value,
                        itemStyle: {
                            normal: {
                                //color:'white',
                                label: {
                                    show: true
                                }
                            }
                        },
                        children: [
                            {
                                name: pic_tree_data[0].children[0].name,
                                value: pic_tree_data[0].children[0].value,
                                symbol: 'diamond',
                                itemStyle: {
                                    normal: {
                                        color: '#ff6700',
                                        label: {
                                            show: true
                                        }
                                    }
                                },
                                children: [
                                    {
                                        name: pic_tree_data[0].children[0].children[1].name,
                                        value: pic_tree_data[0].children[0].children[1].value,
                                        symbol: 'diamond',
                                        symbolSize: 20,
                                        itemStyle: {
                                            normal: {
                                                label: {
                                                    show: true,
                                                    formatter: "{b}"
                                                },
                                                color: '#ff6700',
                                                borderWidth: 0,
                                                borderColor: '#cc66ff'

                                            },
                                            emphasis: {
                                                borderWidth: 0
                                            }
                                        }
                                    },
                                    {
                                        name: pic_tree_data[0].children[0].children[2].name,
                                        value: pic_tree_data[0].children[0].children[2].value,
                                        symbol: 'diamond',
                                        symbolSize: 20,
                                        itemStyle: {
                                            normal: {
                                                label: {
                                                },
                                                color: '#ff6700',
                                                brushType: 'stroke',
                                                borderWidth: 0,
                                                borderColor: '#999966'
                                            },
                                            emphasis: {
                                                borderWidth: 0
                                            }
                                        }
                                    },
                                    {
                                        name: pic_tree_data[0].children[0].children[3].name,
                                        value: pic_tree_data[0].children[0].children[3].value,
                                        symbol: 'diamond',
                                        symbolSize: 20,
                                        itemStyle: {
                                            normal: {
                                                label: {
                                                },
                                                color: '#ff6700',
                                                brushType: 'stroke',
                                                borderWidth: 0,
                                                borderColor: '#999966'
                                            },
                                            emphasis: {
                                                borderWidth: 0
                                            }
                                        }
                                    },
                                    {
                                        name: pic_tree_data[0].children[0].children[0].name,
                                        symbol: 'diamond',
                                        symbolSize: 20,
                                        layerPadding:380,
                                        value: pic_tree_data[0].children[0].children[0].value,
                                        itemStyle: {
                                            normal: {
                                                label:{
                                                    position:'top'
                                                },
                                                color: '#ff6700',
                                                label: {
                                                    show: true
                                                }
                                            },
                                            emphasis: {
                                                label: {
                                                    show: false
                                                },
                                                borderWidth: 0
                                            }
                                        },
                                        children:[
                                            {
                                                name: '通话时长',
                                                symbol: 'circle',
                                                symbolSize: 20,
                                                value:1,
                                                itemStyle: {
                                                    normal: {
                                                        label:{
                                                            position:'top'
                                                        },
                                                        color: '#afd6dd',
                                                        label: {
                                                            show: true
                                                        }
                                                    },
                                                    emphasis: {
                                                        label: {
                                                            show: false
                                                        },
                                                        borderWidth: 0
                                                    }
                                                },
                                                children:[
                                                    {
                                                        name: pic_tree_data[0].children[0].children[0].children[0].name,
                                                        value: pic_tree_data[0].children[0].children[0].children[0].value,
                                                        symbol: 'circle',
                                                        symbolSize: 20,
                                                        itemStyle: {
                                                            normal: {
                                                                label: {
                                                                    show: true,
                                                                    formatter: "{b}"
                                                                },
                                                                color: '#afd6dd',
                                                                borderWidth: 0,
                                                                borderColor: '#cc66ff'

                                                            },
                                                            emphasis: {
                                                                borderWidth: 0
                                                            }
                                                        }
                                                    },
                                                    {
                                                        name: pic_tree_data[0].children[0].children[0].children[1].name,
                                                        value: pic_tree_data[0].children[0].children[0].children[1].value,
                                                        symbol: 'circle',
                                                        symbolSize: 20,
                                                        itemStyle: {
                                                            normal: {
                                                                label: {
                                                                    show: true,
                                                                    formatter: "{b}"
                                                                },
                                                                color: '#afd6dd',
                                                                borderWidth: 0,
                                                                borderColor: '#cc66ff'

                                                            },
                                                            emphasis: {
                                                                borderWidth: 0
                                                            }
                                                        }
                                                    },
                                                    {
                                                        name: pic_tree_data[0].children[0].children[0].children[2].name,
                                                        value: pic_tree_data[0].children[0].children[0].children[2].value,
                                                        symbol: 'circle',
                                                        symbolSize: 20,
                                                        itemStyle: {
                                                            normal: {
                                                                label: {
                                                                    show: true,
                                                                    formatter: "{b}"
                                                                },
                                                                color: '#afd6dd',
                                                                borderWidth: 0,
                                                                borderColor: '#cc66ff'

                                                            },
                                                            emphasis: {
                                                                borderWidth: 0
                                                            }
                                                        }
                                                    },
                                                    {
                                                        name: pic_tree_data[0].children[0].children[0].children[3].name,
                                                        value: pic_tree_data[0].children[0].children[0].children[3].value,
                                                        symbol: 'circle',
                                                        symbolSize: 20,
                                                        itemStyle: {
                                                            normal: {
                                                                label: {
                                                                    show: true,
                                                                    formatter: "{b}"
                                                                },
                                                                color: '#afd6dd',
                                                                borderWidth: 0,
                                                                borderColor: '#cc66ff'

                                                            },
                                                            emphasis: {
                                                                borderWidth: 0
                                                            }
                                                        }
                                                    },
                                                    {
                                                        name: pic_tree_data[0].children[0].children[0].children[4].name,
                                                        value: pic_tree_data[0].children[0].children[0].children[4].value,
                                                        symbol: 'circle',
                                                        symbolSize: 20,
                                                        itemStyle: {
                                                            normal: {
                                                                label: {
                                                                    show: true,
                                                                    formatter: "{b}"
                                                                },
                                                                color: '#afd6dd',
                                                                borderWidth: 0,
                                                                borderColor: '#cc66ff'

                                                            },
                                                            emphasis: {
                                                                borderWidth: 0
                                                            }
                                                        }
                                                    },
                                                    {
                                                        name: pic_tree_data[0].children[0].children[0].children[5].name,
                                                        value: pic_tree_data[0].children[0].children[0].children[5].value,
                                                        symbol: 'circle',
                                                        symbolSize: 20,
                                                        itemStyle: {
                                                            normal: {
                                                                label: {
                                                                    show: true,
                                                                    formatter: "{b}"
                                                                },
                                                                color: '#afd6dd',
                                                                borderWidth: 0,
                                                                borderColor: '#cc66ff'

                                                            },
                                                            emphasis: {
                                                                borderWidth: 0
                                                            }
                                                        }
                                                    },
                                                    {
                                                        name: pic_tree_data[0].children[0].children[0].children[6].name,
                                                        value: pic_tree_data[0].children[0].children[0].children[6].value,
                                                        symbol: 'circle',
                                                        symbolSize: 20,
                                                        itemStyle: {
                                                            normal: {
                                                                label: {
                                                                    show: true,
                                                                    formatter: "{b}"
                                                                },
                                                                color: '#afd6dd',
                                                                borderWidth: 0,
                                                                borderColor: '#cc66ff'

                                                            },
                                                            emphasis: {
                                                                borderWidth: 0
                                                            }
                                                        }
                                                    }

                                                ]
                                            }
                                        ]

                                    }
                                ]
                            },
                            {
                                name:pic_tree_data[0].children[1].name,
                                itemStyle: {
                                    normal: {
                                        label: {
                                            show: true
                                        }

                                    }
                                },
                                value: pic_tree_data[0].children[1].value
                            },
                            {
                                name: pic_tree_data[0].children[2].name,
                                itemStyle: {
                                    normal: {
                                        label: {
                                            show: true
                                        }

                                    }
                                },
                                value: pic_tree_data[0].children[2].value,
                                children:[
                                    {
                                        name: pic_tree_data[0].children[2].children[0].name,
                                        symbol: 'circle',
                                        symbolSize: 20,
                                        value: pic_tree_data[0].children[2].children[0].value,
                                        itemStyle: {
                                            normal: {
                                                color: '#afd6dd',
                                                label: {
                                                    show: true
                                                }
                                            },
                                            emphasis: {
                                                label: {
                                                    show: false
                                                },
                                                borderWidth: 0
                                            }
                                        }
                                    },
                                    {
                                        name: pic_tree_data[0].children[2].children[1].name,
                                        symbol: 'circle',
                                        symbolSize: 20,
                                        value: pic_tree_data[0].children[2].children[1].value,
                                        itemStyle: {
                                            normal: {
                                                color: '#afd6dd',
                                                label: {
                                                    show: true
                                                }
                                            },
                                            emphasis: {
                                                label: {
                                                    show: false
                                                },
                                                borderWidth: 0
                                            }
                                        }
                                    },
                                    {
                                        name: pic_tree_data[0].children[2].children[2].name,
                                        symbol: 'circle',
                                        symbolSize: 20,
                                        value: pic_tree_data[0].children[2].children[2].value,
                                        itemStyle: {
                                            normal: {
                                                color: '#afd6dd',
                                                label: {
                                                    show: true
                                                }
                                            },
                                            emphasis: {
                                                label: {
                                                    show: false
                                                },
                                                borderWidth: 0
                                            }
                                        }
                                    }
                                ]
                            }
                        ]
                    }
                ]
            }
        ]
    };
    pic_tree_chart.setOption(pic_tree_option);
    window.addEventListener("resize", function () {
        pic_tree_chart.resize();
    });
    pic_tree_chart.on('click', getNewGraph);
}

function createRandomItemStyle() {//字符云生成样式
    return {
        normal: {
            color: 'rgb(' + [
                Math.round(Math.random() * 160),
                Math.round(Math.random() * 160),
                Math.round(Math.random() * 160)
            ].join(',') + ')'
        }
    };
}

function word_cloud(id){
    if(!document.getElementById(id))return;
    var word_cloud_chart = echarts.init(document.getElementById(id));
    var wordCloudOption = {};
    $.extend(true, wordCloudOption, option);
    wordCloudOption.series = [{
        name: '字符云',
        type: 'wordCloud',
        size: ['100%', '100%'],
        textRotation : [0, 45, 90, -45],
        textPadding: 2,//一定要有间距，不然tooltip容易出错
        autoSize: {
            enable: true,
            maxSize:40
        },
        data: wordData
    }];
    wordCloudOption.tooltip = {
        show: true,
        formatter: function (params) {
            var res = '游戏名称 : <br/>' + params.name+' <br/>';
            res += '游戏id :' + params.data.appid+' <br/>';
            res += '活跃 : ' + params.data.active+'<br/>';
            res += '新增 :' + params.data.append_user+' <br/>';
            res += '下载 :' + params.data.down+' <br/>';
            res += '收入 :' + params.data.pay+' <br/>';
            return res;
        }
    };
    wordCloudOption.calculable=false;
    word_cloud_chart.setOption(wordCloudOption);
    window.addEventListener("resize", function () {
        word_cloud_chart.resize();
    });

    word_cloud_chart.on('click', cloudClick);
    function cloudClick(paras){
        console.log('你点击的是：'+paras.name);
        window.open("http://www.huyu-inc.com/data/games/gameView?id="+paras.data.appid);
    }
}
function two_bar_twoy(id) {
    if(!document.getElementById(id))return;
    var TbtChart = echarts.init(document.getElementById(id));
    var TbtOption = {};
    $.extend(true, TbtOption, option);
    TbtOption.tooltip.trigger= 'axis';
    TbtOption.legend = {
        //y:'bottom',
        data: TbtLegendData
    };
    //TbtOption.title = {
    //    x:'center',
    //    y:'top',
    //    text: '活跃时长在'+titlename+'分钟用户消息类型'
    //};
    //TbtOption.grid =  {
    //    y2: 80
    //};
    TbtOption.xAxis = [
        {
            type : 'category',

            boundaryGap: true,
            data : TbtXData,
            splitLine:false
        }
    ];
    TbtOption.yAxis =  [
        {
            type : 'value'
        },
        {
            type : 'value',
            position: 'left'
        }
    ];
    TbtOption.series= [
        {
            name: TbtLegendData[0],
            type: 'bar',
            data:TbtData[0]
        },
        {
            name: TbtLegendData[1],
            type: 'bar',
            data:TbtData[1]
        },
        {
            name:TbtLegendData[2],
            type: 'line',
            yAxisIndex: 1,
            data:TbtData[2],
            itemStyle : {
                normal : {
                    lineStyle : {
                        color:"#6E6E6E"
                    }
                }
            }
        }
    ];
    TbtChart.setOption(TbtOption);
    window.addEventListener("resize", function () {
        TbtChart.resize();
    });
}
function whirlwind_pic(id) {
    if(!document.getElementById(id))return;
    var WindChart = echarts.init(document.getElementById(id));
    var WindOption = {};
    $.extend(true, WindOption, option);
    WindOption.tooltip.trigger= 'axis';
    WindOption.tooltip = {
        trigger: 'axis',
        axisPointer : {
            type : 'shadow'
        }
    };
    WindOption.legend = {
        //y:'bottom',
        data: WindLegendData
    };
    WindOption.xAxis = [
        {
            type : 'value'
        }
    ];
    WindOption.yAxis =  [
        {
            type : 'category',
            axisTick : {show: false},
            data : WindXData
        }
    ];
    WindOption.series= [
        {
            name:WindLegendData[0],
            type:'bar',
            barWidth : 8,
            stack: 'and',
            itemStyle : { normal: {label : {show: true, position: 'right'}}},
            data:WindData[0]
        },
        {
            name:WindLegendData[1],
            type:'bar',
            stack: 'ios',
            barWidth : 8,
            itemStyle : { normal: {label : {show: true, position: 'right'}}},
            data:WindData[1]
        },
        {
            name:WindLegendData[2],
            type:'bar',
            stack: 'and',
            barWidth : 8,
            itemStyle: {normal: {
                label : {show: true, position: 'left'}
            }},
            data:WindData[2]
        },
        {
            name:WindLegendData[3],
            type:'bar',
            stack: 'ios',
            barWidth : 8,
            itemStyle: {normal: {
                label : {show: true, position: 'left'}
            }},
            data:WindData[3]
        }
    ];
    WindChart.setOption(WindOption);
    window.addEventListener("resize", function () {
        WindChart.resize();
    });
}

function test_with_toolbox(id) {
    if(!document.getElementById(id))return;
    var testChart = echarts.init(document.getElementById(id));
    var testOption = {};
    $.extend(true, testOption, option);
    testOption.tooltip = {
        trigger: 'axis'
    };
    testOption.color = [
        '#2ec7c9','#c14089','#588dd5','#e5cf0d','#d87a80',
        '#8d98b3','#97b552','#95706d','#dc69aa',
        '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
        '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
    ];
    // testOption.dataZoom = {
    //     show: false,
    //     realtime : true,
    //     start : 30,
    //     end : 60,
    //     height:25
    // };
    testOption.toolbox = {
        show:true,
        feature  : {
            //mark : {show: true},
            dataView : {show: true, readOnly: false}
            //magicType : {show: true, type: ['line', 'bar']},
            //restore : {show: true},
            //saveAsImage : {show: true}
        }
    };
    testOption.legend = {
        data: testLegendData_box
    };
    testOption.grid =  {
        y2: 80
    };
    testOption.xAxis = [
        {
            type: 'category',
            boundaryGap : false,
            data:testXData_box,
            splitLine:false
            //axisLabel:{
            //    interval:6//x轴隔六个显示
            //}
        }
    ];
    testOption.yAxis = [
        {type: 'value'}
    ];
    testOption.series=[];
    for(var i=0;i<testLegendData_box.length;i++){
        var eachSeries = {};
        eachSeries.name = testLegendData_box[i];
        eachSeries.type = 'line';
        eachSeries.symbol= 'none';
        eachSeries.data = testYData_box[i];
        testOption.series.push(eachSeries);
    }
    testChart.setOption(testOption);
    window.addEventListener("resize", function () {
        testChart.resize();
    });
}
function test_lou(id) {
    if(!document.getElementById(id))return;
    var testChart_l = echarts.init(document.getElementById(id));
    var testOption_l = {};
    $.extend(true, testOption_l, option);

    testOption_l.tooltip = {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c}%"
    };
    testOption_l.legend = {
        data: louLegendData
    };

    testOption_l.calculable=true;
    testOption_l.series = [
        {
            name:louNameData,
            type:'funnel',
            x: '10%',
            y: 60,
            //x2: 80,
            y2: 60,
            width: '80%',
            // height: {totalHeight} - y - y2,
            min: 0,
            max: 100,
            minSize: '0%',
            maxSize: '100%',
            sort : 'descending', // 'ascending', 'descending'
            gap : 10,
            itemStyle: {
                normal: {
                    // color: 各异,
                    borderColor: '#fff',
                    borderWidth: 1,
                    label: {
                        show: true,
                        position: 'inside'
                        // textStyle: null      // 默认使用全局文本样式，详见TEXTSTYLE
                    },
                    labelLine: {
                        show: false,
                        length: 10,
                        lineStyle: {
                            // color: 各异,
                            width: 1,
                            type: 'solid'
                        }
                    }
                },
                emphasis: {
                    // color: 各异,
                    borderColor: 'red',
                    borderWidth: 5,
                    label: {
                        show: true,
                        formatter: '{b}:{c}',
                        textStyle:{
                            fontSize:20
                        }
                    },
                    labelLine: {
                        show: true
                    }
                }
            },
            data:louData
        }
    ];
    testOption_l.toolbox = {
        show:true,
        feature  : {
            dataView : {show: true,optionToContent: function (opt){
                var table = '';
                for (var i = louLegendData.length - 1; i >= 0; i--) {

                    table += louLegendData[i]+'&nbsp';
                }
                return table;
            }}
        }
    };

    testChart_l.setOption(testOption_l);
    window.addEventListener("resize", function () {
        testChart_l.resize();
    });
}

