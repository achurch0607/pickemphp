
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{config('constants.options.SEASON_YEAR')}}  {{ __('Schedule') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <form method="get" id='weekForm'>
             <label > Select Week</label>
                <select name="week" id="week" class="form-control" onchange="document.getElementById('weekForm').submit()">
                    @for ($i = 0; $i < 18; $i++)
                        <option value="{{$i}}" @if($i == $currentWeek) selected @endif>{{$i}}</option>
                    @endfor
                </select>
            </form>
        </div>
        <?php  print_r($currentSchedule); ?>
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
                  <tr>
                    <td>
                        <input type='radio' name='{{$game->gameID}}' value='{{$game->visitorID}}' id='{{$game->visitorID}}'><br>
                        <label for='{{$game->visitorID}}'><img src = "{{ asset('/img/logos/'.$game->visitorID.'.gif') }}" />{{$game->visitorID}}</label>
                    </td>
                    <td>
                        <input type='radio' name='{{$game->gameID}}' value='{{$game->homeID}}' id='{{$game->homeID}}'><br>
                        <label for='{{$game->homeID}}'><img src = "{{ asset('/img/logos/'.$game->homeID.'.gif') }}" />{{$game->homeID}}</label>

                    </td>
                    <td>{{$game->gameTimeEastern}}</td>

                  </tr>
                  @endforeach
                </tbody>
            </table>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <button type="submit" class="btn btn-primary">Submit</button><!-- comment -->
            </div>
      </form>
        <!--<button type="submit">submit picks</button>-->
    </div>
</x-app-layout>