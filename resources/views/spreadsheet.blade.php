@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-header">Read Dump PNL spreadsheet</div>

            <div class="card-body">
                @php var_dump($data); @endphp
                <br>
                @php var_dump($values); @endphp
                <br>
                @php var_dump($totals); @endphp
                <br>
                @php var_dump($overall); @endphp
                <br>
                @php var_dump($percentage); @endphp
                <br>
                @php var_dump($sparkline); @endphp
                <br>
                @php echo("Labels-Keys: '" . $caption . "'"); @endphp
                <br>
                 @php echo $message; @endphp
            </div>
        </div>
    </div>
</div>
@endsection