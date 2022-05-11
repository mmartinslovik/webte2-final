<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cas') }}
        </h2>
    </x-slot>

    <div class="flex p-12 flex-col justify-items-center">
        <div class="container px-6 py-12 h-full">
            <div class="flex justify-center items-center flex-wrap h-full g-6 text-gray-800">
                <div class="md:w-8/12 lg:w-5/12 lg:ml-20">
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
                </div>
            </div>
        </div>
        @if(isset($result))
            <div>
                {{ json_encode($result) }}
            </div>
        @endif
    </div>
</x-app-layout>
