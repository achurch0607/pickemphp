<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>        
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Select team to view their schedule</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teams as $team)
                                <tr>
                                    <td> 
                                        
                                        <img src = "{{ asset('/img/logos/'.$team->teamID.'.gif') }}" />
                                        <b>{{$team->city}} {{$team->team}}</b>
                                        
                                    </td>   
                                </tr>
                                <tr></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
             </div>
        </div>
    </div>
</x-app-layout>