<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Watch') }}
        </h2>
    </x-slot>

    <div class="flex px-12 flex-row justify-center">
        <div class="container px-6 py-12 h-full">
            <div class="flex justify-center items-center flex-wrap h-full g-6 text-gray-800">
                <div class="md:w-8/12 lg:w-5/12 lg:ml-20">


                    <div class="mb-6">
                        <label class="form-check-label inline-block text-gray-800" for="email1">{{ __('Email address') }}</label>
                        <input id="email1" type="email" class="form-control block w-full px-4 py-2 font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="jan.vajan@mail.com" name="email" />
                    </div>

                    <button type="button" onclick="startWatching()" class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-full" data-mdb-ripple="true" data-mdb-ripple-color="light">
                        {{ __('Watch') }}
                    </button>

                    <div class="mt-4">
                        <div class="mb-6">
                            <label class="form-check-label inline-block text-gray-800" for="rvalue">{{ __('Plot') }}</label>
                            <input type="number" class="
                                form-control
                                block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding
                                border border-solid border-gray-300
                                rounded
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
                                font-normal
                                " id="rvalue" placeholder="{{ __('Value of r <0.35, 0.07>, <-0.07, -0.35>') }}" name="r" min="-0.35" max="0.35" step="0.01" disabled></input>
                        </div>
                    </div>




                        <div><canvas id="myChart"></canvas></div>
                        <div>
                            <div style="display: grid; grid-template-columns: auto auto;">
                                <div style="text-align: center;">
                                    <p style="color: red;">{{ __('Wheel') }}</p>
                                </div>
                                <div style="text-align: center;">
                                    <p style="color: blue;">{{ __('Car') }}</p>
                                </div>
                            </div>
                        </div>
                        <div id="canvas"></div>
                </div>

            </div>
            <script>
                //const socket = new WebSocket('wss://localhost:9000')
                const socket = new WebSocket('ws://localhost:9000');
                let email = null;
                let parsedData = null;
                let graphExists = false;
                let isAnimating = false;
                let count = 0;

                const animationWidth = 500;
                const animationHeight = 300;
                let car;

                class MyString {
                    constructor(x, y, w, h, canvasHeight) {
                        this.x = x
                        this.y = y;
                        this.w = w;
                        this.h = h;
                        this.height = this.y - this.h;
                        this.cycle = ceil(this.height / 50);
                        this.stringHeight = (this.height / this.cycle);
                        this.stringHeight = (this.stringHeight / 2);
                        this.canvasHeight = canvasHeight;
                        this.stringWidth = 25;
                    }

                    display() {
                        for (let i = 0; i < this.cycle; i++) {
                            this.currentHeight = this.currentHeight - this.stringHeight;
                            line(this.x, this.currentHeight + this.stringHeight, this.x - this.stringWidth, this.currentHeight);
                            line(this.x - this.stringWidth, this.currentHeight, this.x, this.currentHeight - this.stringHeight);
                            this.currentHeight = this.currentHeight - this.stringHeight;

                        }
                        this.currentHeight = this.y
                    }

                    deviation(dev) {
                        this.height = this.y - dev;
                        this.stringHeight = (this.height / this.cycle);
                        this.stringHeight = (this.stringHeight / 2);

                        this.display();
                    }

                    changeY(dev, y) {
                        this.y = y
                        this.height = this.y - dev;
                        this.stringHeight = (this.height / this.cycle);
                        this.stringHeight = (this.stringHeight / 2);
                        this.display();
                    }

                }

                class Car {
                    constructor(x, y, w, h, canvasHeight, car) {
                        this.x = x;
                        this.y = y;
                        this.w = w;
                        this.h = h;
                        this.car = car;
                        this.distance = canvasHeight / 4;
                        this.canvasHeight = canvasHeight;
                        this.string = new MyString(x + w - w / 3, this.canvasHeight, w + w - w / 3, this.y + this.h, this.canvasHeight);
                    }

                    deviation(dev) {
                        this.y = dev;
                        this.string.deviation(dev + this.h);
                        this.display();
                    }

                    display() {
                        this.string.display();

                        line(this.x + this.w / 5, this.canvasHeight, this.x + this.w / 5, this.y);

                        stroke(0);
                        if (this.car == 1) {
                            fill(color(0, 0, 255));
                        } else {
                            fill(color(255, 0, 0));
                        }
                        rect(this.x, this.y, this.w, this.h);
                    }

                    upperObjDev(car, dev) {
                        this.y = dev;
                        this.canvasHeight = car.y;
                        this.string.changeY(dev + this.h, car.y)

                        this.display();
                    }
                }

                var data;
                var data2;
                var data3;
                var data5;

                let flag = true;

                /*myChart = new Chart(ctx, config2);
                graphExists = true;*/

                let ctx = document.getElementById('myChart').getContext('2d');
                const config2 = {
                    type: 'line',
                    data: {
                        datasets: [{
                            borderColor: 'red',
                            borderWidth: 1,
                            radius: 0,
                            data: [],
                        },
                            {
                                borderColor: 'blue',
                                borderWidth: 1,
                                radius: 0,
                                data: [],
                            }
                        ]
                    },
                    options: {
                        interaction: {
                            intersect: false
                        },
                        plugins: {
                            legend: false
                        },
                        scales: {
                            x: {
                                type: 'linear',
                                min: 0,
                                max: 500
                            },
                            y: {
                                type: 'linear',
                                min: -100,
                                max: 100
                            }
                        }
                    }
                };

                myChart = new Chart(ctx, config2);
                graphExists = true;

                function setup() {
                    var myCanvas = createCanvas(animationWidth, animationHeight);
                    myCanvas.parent("canvas");
                    car = new Car(100, 170, 80, 35, animationHeight, 0);
                    wheel = new Car(100, 70, 80, 35, car.y, 1);
                }

                function draw() {
                    background(245);
                    car.display();
                    wheel.display();
                }


                socket.addEventListener("message", msg => {
                    const jsonData = JSON.parse(msg.data);
                    console.log(jsonData);

                    if(email && jsonData.email===email){

                        document.getElementById("rvalue").value = jsonData.r;

                        if ((!jsonData.result && count===0)){
                            //console.log("len raz");
                        }
                        else{
                            //console.log(jsonData);
                            parsedData = jsonData;

                            if (jsonData.result){
                                data = [];
                                data2 = [];

                                for (let i = 0; i < parsedData['result'].length - 1; i++) {
                                    data.push({
                                        x: i,
                                        y: parsedData['result'][i]['x1']
                                    })
                                    data2.push({
                                        x: i,
                                        y: parsedData['result'][i]['x3']
                                    })
                                }

                                data3 = [];
                                data5 = [];

                                for (let i = 0; i < parsedData['result'].length - 1; i++) {
                                    data3.push(parsedData['result'][i]['x1']);
                                    data5.push(parsedData['result'][i]['x3']);
                                }
                            }



                            const totalDuration = 5000;
                            const delayBetweenPoints = totalDuration / data.length;
                            const previousY = (ctx) => ctx.index === 0 ? ctx.chart.scales.y.getPixelForValue(100) : ctx.chart.getDatasetMeta(ctx.datasetIndex).data[ctx.index - 1].getProps(['y'], true).y;

                            const progress = document.getElementById('myRange');
                            ctx = document.getElementById('myChart').getContext('2d');

                            const config = {
                                type: 'line',
                                data: {
                                    datasets: [{
                                        borderColor: 'red',
                                        borderWidth: 1,
                                        radius: 0,
                                        data: data,
                                    },
                                        {
                                            borderColor: 'blue',
                                            borderWidth: 1,
                                            radius: 0,
                                            data: data2,
                                        }
                                    ]
                                },
                                options: {
                                    animation: {

                                        x: {
                                            type: 'number',
                                            easing: 'linear',
                                            duration: delayBetweenPoints,
                                            from: NaN, // the point is initially skipped
                                            delay(ctx) {
                                                if (ctx.type !== 'data' || ctx.xStarted) {
                                                    return 0;
                                                }
                                                ctx.xStarted = true;
                                                return ctx.index * delayBetweenPoints;
                                            }
                                        },
                                        y: {
                                            type: 'number',
                                            easing: 'linear',
                                            duration: delayBetweenPoints,
                                            from: previousY,
                                            delay(ctx) {
                                                if (ctx.type !== 'data' || ctx.yStarted) {
                                                    return 0;
                                                }
                                                ctx.yStarted = true;
                                                return ctx.index * delayBetweenPoints;
                                            },
                                        }
                                    },
                                    interaction: {
                                        intersect: false
                                    },
                                    plugins: {
                                        legend: false
                                    },
                                    scales: {
                                        x: {
                                            type: 'linear'
                                        }
                                    }
                                }
                            };




                            if (flag) {
                                flag = false
                            } else {
                                flag = true
                            }
                            if (!flag){
                                konstanta = 200
                                dis = 150

                                if (graphExists){
                                    myChart.destroy();
                                }
                                myChart = new Chart(ctx, config);
                                graphExists = true;

                                animation();
                            }else{
                                if (graphExists){
                                    myChart.destroy();

                                    myChart = new Chart(ctx, config2);
                                    graphExists = true;
                                }
                            }
                        }
                        count++;


                    }


                })

                async function animation(){
                    for (let i = 0; i < data3.length; i++) {
                        await new Promise(resolve => setTimeout(resolve, 50));
                        car.deviation(Math.abs(data3[i]) * konstanta + dis);
                        // car.deviation((data3[i] - data5[i]) * konstanta);
                        // wheel.upperObjDev(car, Math.abs(data3[i] - data5[i]) * konstanta)
                        wheel.upperObjDev(car, Math.abs(data5[i]) * konstanta * 10 + 75)
                        if (flag) {
                            break;
                        }
                    }
                }

                function startWatching(){
                    email = document.getElementById("email1").value;

                    count = 0;
                }

            </script>
        </div>
    </div>
    </div>
    </div>

    <div class="flex justify-center items-center flex-wrap h-full g-6 text-gray-800">
        <div class="md:w-8/12 lg:w-5/12 lg:ml-20">

        </div>
    </div>

</x-app-layout>
