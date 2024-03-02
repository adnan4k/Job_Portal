<x-mail::message>
# Introduction

Congrotulation You are now primeum member
<p>Your purchase details:</p>
<p>Plan:{{$plan}}</p>
<p>Your Plan ends on:{{$billingEnds}}</p>
<x-mail::button :url="''">
Post a Job
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
