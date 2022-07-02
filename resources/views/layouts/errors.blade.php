@if ($errors->any())
<div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-5 text-center fw-bold">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif