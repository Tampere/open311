@component('mail::message')
# Palautteesi tila on muuttunut

Antamasi palautteen '{{$request->description}}' tila on muuttunut.

Palautteesi tila on nyt
@if($request->status === 'open')
    avoin.
@elseif($request->status === 'closed')
    suljettu.
@elseif($request->status === 'pending')
    odottava.
@endif

@if(strlen($request->status_notes) > 0)
    Palautteellesi on annettu seuraava tilaviesti: <br> {{$request->status_notes}}
@endif

Ystävällisin terveisin,<br>
Konsernipalveluyksikkö Koppari
@endcomponent
