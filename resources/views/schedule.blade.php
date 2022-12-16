
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" >
          {{config('constants.options.SEASON_YEAR')}}  {{ __('Schedule') }}
        </h2> <div style="float: right;">
            <form method="get" id='weekForm'>
                <label > Select Week</label>
                <select name="week" id="week" class="form-control" onchange="document.getElementById('weekForm').submit()">
                    @for ($i = 0; $i <= 18; $i++)
                        <option value="{{$i}}" @if($i == $selectedWeek) selected @endif>{{$i}}</option>
                    @endfor
                </select>
            </form>
        </div>
    </x-slot>
    <div class="py-12">
<div style="overflow-x:auto;">
        <form method="POST" id='userPicks' action="{{url('/insertPicks')}}">
            @csrf
            <table>
                <thead>
                  <tr>
                    <th>Home Team</th>
                    <th>Away Team</th>
                    <th>Game Time (EST)</th>
                  </tr>
                </thead>
                <tbody>                  
                    @foreach($currentSchedule as $game)
                   @php
                        $visitorSelected = '';
                        $homeSelected = '';
                        $disabled = '';
                        if (isset($userPicks[$game->gameID]) && $userPicks[$game->gameID] == $game->visitorID) {
                            $visitorSelected = 'checked';
                            
                        } elseif (isset($userPicks[$game->gameID]) && $userPicks[$game->gameID] == $game->homeID) {
                            $homeSelected = 'checked';
                        }
                        
                        if(in_array($game->gameID, $expiredGames)) {
                            $disabled = 'disabled';
                        }
                    @endphp
                  <tr>
                    <td>
                        <input type='radio' name='{{$game->gameID}}' value='{{$game->visitorID}}' id='{{$game->visitorID}}' {{$visitorSelected}} {{$disabled}}/><br>
                        <label for='{{$game->visitorID}}'><img src = "{{ asset('/img/logos/'.$game->visitorID.'.gif') }}" {{$disabled}}/>{{$game->visitorID}}</label>
                    </td>
                    <td>
                        <input type='radio' name='{{$game->gameID}}' value='{{$game->homeID}}' id='{{$game->homeID}}' {{$homeSelected}} {{$disabled}}/><br>
                        <label for='{{$game->homeID}}'><img src = "{{ asset('/img/logos/'.$game->homeID.'.gif') }}" {{$disabled}}/>{{$game->homeID}} </label>

                    </td>
                    @if (($game->homeScore > 0))  || ($game->visitorScore > 0))
                        <td>{{$game->gameTimeEastern}}</td>
                    @else
                        <td>{{$game->gameTimeEastern}} SET SCORE</td>
                    @endif
                    

                  </tr>
                  @endforeach
                </tbody>
            </table>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <input type="submit" value="submit">
            </div>
      </form>
</div>
        <!--<button type="submit">submit picks</button>-->
    </div>
</x-app-layout>