@extends('admin.default')

@section('page-header')
    Home Categories <small>{{ trans('app.manage') }}</small>
@endsection

@push('css')
    <style>
        ul {
            padding: 0px;
            margin: 0px;
        }

        #list li {
            margin: 0 0 3px;
            padding: 8px;
            background-color: #00CCCC;
            color: #fff;
            list-style: none;
            border: #CCCCCC solid 1px;
        }
    </style>
@endpush

@section('content')

    <div class="mB-20">
        @if($categories->count() > 0 && $items->count() > 0)
        <button data-toggle="modal" data-target="#AddModal" class="btn btn-info" onclick="getBusiness()">
            {{ trans('app.add_button') }}
        </button>
        @elseif($items->count() == 0)
            <p class="text-danger">* Business must be created</p>
        @else()
            <p class="text-danger">* Categories must be created or actived</p>
        @endif
    </div>

    <div class="mB-20">
        <select class="form-control w-25" name="idcategories" id="idcategories">
            @foreach($categories as $categoy)
                <option value="{{ $categoy->idcategories }}">{{ $categoy->name }}</option>
            @endforeach
        </select>
    </div>

    <div id="container" style="width:300px;">
        <div id="list">
            <ul id="container_hc">
            </ul>
        </div>
    </div>

    @include('admin.home_categories.modal_form_hc')

@endsection

@push('js')
    <script>
        $(document).ready(function () {

            @if($categories->count() > 0)
            getHomeCategories({{$categories[0]->idcategories}})
            @endif

            $(function () {
                $("#list ul").sortable({
                    opacity: 0.8, cursor: 'move', update: function () {
                        const order = $(this).sortable("toArray");
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                            type: 'POST',
                            url: '/admin/home_categories_update',
                            data: {business_order: order},
                            success: function (res) {
                                getHomeCategories(res)
                            }
                        });
                    }
                });
            });
        });

        $('#idcategories').change(function () {
            const idcategories = $(this).val();
            getHomeCategories(idcategories)
        });

        function getHomeCategories(idcategories) {
            $('#container_hc').html('<p>Loading ...</p>');
            $.ajax({
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                type: 'POST',
                url: '/admin/home_categories_list',
                data: {idcategories: idcategories},
                success: function (res) {
                    setHomeCategories(res.data);
                }
            });
        }

        function setHomeCategories(data) {
            let tmp = '';
            if (data.length > 0) {
                data.forEach((item) => {
                    tmp += `<li id="${item.business.idbusiness}">
                            ${item.order}. ${item.business.name}
                            <div class="clear"></div>
                        </li>`;
                    $('#container_hc').html(tmp);
                });
            } else {
                $('#container_hc').html('<h3>There are no Businesses in this Home Category</h3>');
            }
        }
    </script>
@endpush
