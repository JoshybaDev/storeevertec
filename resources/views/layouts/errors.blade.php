@if ($errors->any())
<div class="row">
    <div class="col-lg-12 text-center fw-bold">
        <div style="margin:auto;width:300px">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>            
        </div>
    </div>
</div>
@endif