@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Upload Profit & Lost Tracker Excel Spreadsheet File') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('store') }}" aria-label="{{ __('Upload') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Excel File') }}</label>

                            <div class="col-md-6">
                                <input id="file" type="file" accept=".xlsx, .xls, .csv" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" name="file" value="{{ old('file') }}" placeholder="DIYTrafficGuy Excel file" onchange="checkIsExcel(this);" required>

                                @if ($errors->has('file'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Upload') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
    function checkIsExcel(sender) {
        var validExts = new Array(".xlsx", ".xls", ".csv");
        var fileExt = sender.value;                

        fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
        if (validExts.indexOf(fileExt) < 0 && fileExt != "") {
            alert("Invalid file selected, valid files are of " +  validExts.toString() + " types.");
            sender.value = "";
            return false;
        }
        return true;
    }
</script>
@endsection
