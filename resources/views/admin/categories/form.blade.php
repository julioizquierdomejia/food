@push('css')
    <style>
        input[type="checkbox"].ios8-switch {
            position: absolute;
            margin: 8px 0 0 16px;
        }

        input[type="checkbox"].ios8-switch + label {
            position: relative;
            padding: 5px 0 0 50px;
            line-height: 2.0em;
        }

        input[type="checkbox"].ios8-switch + label:before {
            content: "";
            position: absolute;
            display: block;
            left: 0;
            top: 0;
            width: 40px; /* x*5 */
            height: 24px; /* x*3 */
            border-radius: 16px; /* x*2 */
            background: #fff;
            border: 1px solid #d9d9d9;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
        }

        input[type="checkbox"].ios8-switch + label:after {
            content: "";
            position: absolute;
            display: block;
            left: 0px;
            top: 0px;
            width: 24px; /* x*3 */
            height: 24px; /* x*3 */
            border-radius: 16px; /* x*2 */
            background: #fff;
            border: 1px solid #d9d9d9;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
        }

        input[type="checkbox"].ios8-switch + label:hover:after {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        input[type="checkbox"].ios8-switch:checked + label:after {
            margin-left: 16px;
        }

        input[type="checkbox"].ios8-switch:checked + label:before {
            background: #2196f3;
        }
    </style>
@endpush
<div class="row mB-40">
    <div class="col-sm-8">
        <div class="bgc-white p-20 bd">

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}">
            </div>
            <div class="form-group">
                <input type="checkbox" class="ios8-switch" id="status" name="status" @if($item->status) checked @endif>
                <label for="status">Active</label>
            </div>
        </div>
    </div>
</div>
