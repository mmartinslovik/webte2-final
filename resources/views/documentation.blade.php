<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Documentation') }}
        </h2>
    </x-slot>

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        p {
            text-align: center;
            padding: 1%;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>Rozdelenie úloh:</p>

                    <table>
                        <tr>
                            <th>Šimon</th>
                            <th>Filip</th>
                            <th>Samuel/Martin</th>
                        </tr>
                        <tr>
                            <td>Animácia</td>
                            <td>Synchrónne sledovanie experimentovania</td>
                            <td>API ku CAS</td>
                        </tr>
                        <tr>
                            <td>Graf synchronizovaný s animáciou</td>
                            <td>Finalizacia projektu</td>
                            <td>Docker balíček</td>
                        </tr>
                        <tr>
                            <td>Finalizacia projektu</td>
                            <td></td>
                            <td>Logovanie a export do csv + odoslanie mailu</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Export popisu API do PDF</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Overenie API cez formulár</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Finalizacia projektu</td>
                        </tr>
                    </table>
                    <p>Použité knižnice: p5.js, chart.js</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>