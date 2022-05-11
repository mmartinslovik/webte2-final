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
                    <!-- Command form -->
                    <form action="{{ route('cas') }}" method="post">
                    @csrf
                    <!-- Command input -->
                        <div class="mb-6">
                            <label class="form-check-label inline-block text-gray-800"
                                   for="textarea1">{{ __('Command') }}</label>
                            <textarea
                                class="
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
                                "
                                id="textarea1"
                                rows="15"
                                placeholder="{{ __('Insert octave command') }}"
                                name="command"
                            ></textarea>
                        </div>

                        <!-- Submit button -->
                        <button
                            class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-full"
                            data-mdb-ripple="true"
                            data-mdb-ripple-color="light"
                        >
                            Submit
                        </button>
                    </form>

                    <!-- Send email form -->
                    <form action="{{ route('export') }}" method="post">
                        @csrf
                        <div class="mb-6">
                            <label class="form-check-label inline-block text-gray-800"
                                   for="email1">{{ __('Email address') }}</label>
                            <input
                                id="email1"
                                type="email"
                                class="form-control block w-full px-4 py-2 font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                placeholder="jan.vajan@mail.com" name="email"
                            />
                        </div>

                        <!-- Send email checkbox -->
                        <div class="flex justify-between items-center mb-6">
                            <div class="form-group form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                    id="exampleCheck1" name="sendEmail"
                                />
                                <label class="form-check-label inline-block text-gray-800" for="exampleCheck1"
                                >{{ __('Send email') }}</label
                                >
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button
                            type="submit"
                            class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out w-full"
                            data-mdb-ripple="true"
                            data-mdb-ripple-color="light"
                        >
                            {{ __('Export') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center items-center flex-wrap h-full g-6 text-gray-800">
        <div class="md:w-8/12 lg:w-5/12 lg:ml-20">

        </div>
    </div>

    @if(isset($result))
        <div>
            {{ json_encode($result) }}
        </div>
    @endif

    @if(isset($sent))
        <div id="toast-simple" class="flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x divide-gray-200 rounded-lg shadow dark:text-gray-400 dark:divide-gray-700 space-x dark:bg-gray-800" role="alert">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-500" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M511.6 36.86l-64 415.1c-1.5 9.734-7.375 18.22-15.97 23.05c-4.844 2.719-10.27 4.097-15.68 4.097c-4.188 0-8.319-.8154-12.29-2.472l-122.6-51.1l-50.86 76.29C226.3 508.5 219.8 512 212.8 512C201.3 512 192 502.7 192 491.2v-96.18c0-7.115 2.372-14.03 6.742-19.64L416 96l-293.7 264.3L19.69 317.5C8.438 312.8 .8125 302.2 .0625 289.1s5.469-23.72 16.06-29.77l448-255.1c10.69-6.109 23.88-5.547 34 1.406S513.5 24.72 511.6 36.86z"></path></svg>
            <div class="pl-4 text-sm font-normal">Email sent successfully.</div>
        </div>
    @endif

</x-app-layout>
