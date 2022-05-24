<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cas') }}
        </h2>
    </x-slot>

    <div class="flex px-12 flex-row justify-center">
        <div class="container px-6 py-12 h-full">
            <div class="flex justify-center items-center flex-wrap h-full g-6 text-gray-800">
                <div class="md:w-8/12 lg:w-5/12 lg:ml-20">

                    <form action="{{ route('cas') }}" method="post">
                        @csrf
                        <!-- Command input -->
                        <div class="mb-6">
                            <label class="form-check-label inline-block text-gray-800" for="textarea1">{{ __('Command') }}</label>
                            <input class="
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
                                " id="textarea1" rows="15" placeholder="{{ __('Insert octave command') }}" name="command"></input>
                        </div>

                        <!-- Submit button -->
                        <button class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-full" data-mdb-ripple="true" data-mdb-ripple-color="light">
                            {{ __('Submit') }}
                        </button>
                    </form>
                    @if(isset($result))
                    <br>
                    <div>
                        <p>{{ __('Result') }}:</p>
                        <p id="resultText"></p>
                        <script>
                            var resultJsonData = <?php echo json_encode($result); ?>;
                            // var parsedResultData = JSON.parse(resultJsonData);
                            // console.log(parsedResultData);
                            var resultText = resultJsonData['result'][0]['ans']
                            var cont = document.getElementById('resultText').innerText = resultText;
                        </script>
                        <br>
                    </div>
                    @endif


                    <!-- Send email form -->
                    <form action="{{ route('export') }}" method="post">
                        @csrf
                        <div class="mb-6">
                            <label class="form-check-label inline-block text-gray-800" for="email1">{{ __('Email address') }}</label>
                            <input id="email1" type="email" class="form-control block w-full px-4 py-2 font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="jan.vajan@mail.com" name="email" />
                        </div>

                        <!-- Send email checkbox -->
                        <div class="flex justify-between items-center mb-6">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" id="exampleCheck1" name="sendEmail" />
                                <label class="form-check-label inline-block text-gray-800" for="exampleCheck1">{{ __('Send email') }}</label>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-full" data-mdb-ripple="true" data-mdb-ripple-color="light">
                            {{ __('Export') }}
                        </button>
                    </form>

                    <!-- Send octave command for animation and graph -->
                    <form action="{{ route('coordinates') }}" method="get">
                        <!-- @csrf -->
                        <div class="mb-6">
                            <label class="form-check-label inline-block text-gray-800" for="rvalue">{{ __('Command') }}</label>
                            <input class="
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
                                " id="rvalue" placeholder="{{ __('Insert value of r') }}" name="r"></input>
                        </div>

                        <!-- Submit button -->
                        <button class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-full" data-mdb-ripple="true" data-mdb-ripple-color="light">
                            {{ __('Submit') }}
                        </button>

                    </form>
                    @if(isset($r))
                    <br>
                    <button id="startButton" class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-full" data-mdb-ripple="true" data-mdb-ripple-color="light">{{ __('START') }}</button>

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
                var jsonData = <?php echo json_encode($r);
                                ?>;
                var parsedData = JSON.parse(jsonData);
                var data = []
                var data2 = []
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

                const totalDuration = 5000;
                const delayBetweenPoints = totalDuration / data.length;
                const previousY = (ctx) => ctx.index === 0 ? ctx.chart.scales.y.getPixelForValue(100) : ctx.chart.getDatasetMeta(ctx.datasetIndex).data[ctx.index - 1].getProps(['y'], true).y;

                const progress = document.getElementById('myRange');
                const ctx = document.getElementById('myChart').getContext('2d');

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

                const bttn = document.getElementById('startButton');


                bttn.addEventListener("click", () => {
                    if (start.innerText == "STOP") {
                        myChart.destroy();
                        myChart = new Chart(
                            ctx,
                            config2
                        );

                    } else {
                        myChart.destroy();
                        myChart = new Chart(ctx, config);
                    }
                })

                var myChart = new Chart(
                    ctx,
                    config2
                );
            </script>

            <script>
                const animationWidth = 500;
                const animationHeight = 300;
                const inputBox = document.getElementById("inputbox");
                const submitButton = document.getElementById("odosli");
                const start = document.getElementById("startButton");
                let car;
                data3 = [];
                data5 = [];
                for (let i = 0; i < parsedData['result'].length - 1; i++) {
                    data3.push(parsedData['result'][i]['x1']);
                    data5.push(parsedData['result'][i]['x3']);
                }


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

                var flag = true;

                start.addEventListener("click", async () => {
                    if (start.innerText == "STOP") {
                        start.innerText = "Start";
                    } else {
                        start.innerText = "Stop";
                    }
                    // console.log(data3[22])
                    if (flag) {
                        flag = false
                    } else {
                        flag = true
                    }
                    if (!flag) {

                        konstanta = 100
                        for (let i = 0; i < data3.length; i++) {
                            await new Promise(resolve => setTimeout(resolve, 50));
                            car.deviation(Math.abs(data3[i]) * konstanta + 100);
                            // car.deviation((data3[i] - data5[i]) * konstanta);
                            // wheel.upperObjDev(car, Math.abs(data3[i] - data5[i]) * konstanta)
                            wheel.upperObjDev(car, Math.abs(data5[i]) * konstanta * 10 + 75)
                            if (flag) {
                                break;
                            }
                        }
                    }
                })
            </script>
            @endif

        </div>
    </div>
    </div>
    </div>

    <div class="flex justify-center items-center flex-wrap h-full g-6 text-gray-800">
        <div class="md:w-8/12 lg:w-5/12 lg:ml-20">

        </div>
    </div>




    @if(isset($sent))
    <div id="toast-simple" class="flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x divide-gray-200 rounded-lg shadow dark:text-gray-400 dark:divide-gray-700 space-x dark:bg-gray-800" role="alert">
        <svg class="w-5 h-5 text-blue-600 dark:text-blue-500" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path fill="currentColor" d="M511.6 36.86l-64 415.1c-1.5 9.734-7.375 18.22-15.97 23.05c-4.844 2.719-10.27 4.097-15.68 4.097c-4.188 0-8.319-.8154-12.29-2.472l-122.6-51.1l-50.86 76.29C226.3 508.5 219.8 512 212.8 512C201.3 512 192 502.7 192 491.2v-96.18c0-7.115 2.372-14.03 6.742-19.64L416 96l-293.7 264.3L19.69 317.5C8.438 312.8 .8125 302.2 .0625 289.1s5.469-23.72 16.06-29.77l448-255.1c10.69-6.109 23.88-5.547 34 1.406S513.5 24.72 511.6 36.86z"></path>
        </svg>
        <div class="pl-4 text-sm font-normal">Email sent successfully.</div>
    </div>
    @endif


</x-app-layout>