<x-mail::message>
# Error

KAK! dat gaat niet goed.
Check payment ID:
{{$payment->id}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
