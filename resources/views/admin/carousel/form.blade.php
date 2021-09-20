<div class="row mB-40">
    <div class="col-sm-8">
        <div class="bgc-white p-20 bd">
            {!! Form::myFile('nameimg', 'Banner') !!}
        </div>
    </div>
    @if (isset($item) && $item->avatar)
        <div class="col-sm-4">
            <div class="bgc-white p-20 bd">
                <img src="{{ $item->avatar }}" alt="">
            </div>
        </div>
    @endif
</div>
