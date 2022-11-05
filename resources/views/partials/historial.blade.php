<tbody>
    @foreach ($weather as $weat)
        <tr>
            <td>{{$weat->created_at}}</td>
            <td><img id="icon" src="{{$weat->icon}}" width="30"></td>
            <td>{{$weat->temp}}°C - {{$weat->description}}</td>
            <td>Sensación T. {{$weat->feels_like}}°C</td>
            <td>{{$weat->humidity}}% <i class="fa-solid fa-umbrella"></i></td>
        </tr>
    @endforeach
</tbody>