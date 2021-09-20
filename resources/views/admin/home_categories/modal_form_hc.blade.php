<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Adding Business to Home Category:
                    <span id="category_name" class="font-weight-bold"></span></h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open([
                    'route' => [ ADMIN . '.home_categories.store' ]
                ])
            !!}
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="business_id">Business</label>
                                <select class="form-control" name="business_id" id="business_id">
                                    <option value="">-- Select an Option --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary">
                    Confirm
                </button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('js')
    <script>
        function getBusiness(category = 0) {
            const category_el = $('#idcategories option:selected');
            const category_id = category > 0 ? category : category_el.val();
            $('#category_name').html(category_el.text())

            $.ajax({
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                type: 'POST',
                url: '/admin/business_available_hc',
                data: {category_id: category_id},
                success: function (data) {
                    setBusinessAvailable(data)
                }
            });
        }

        function setBusinessAvailable(data) {
            const element = $('#business_id');
            element.html('')
            let tpl = '';
            data.forEach((item) => {
                tpl += `<option value="${item.idbusiness}">${item.name}</option>`;
            });
            element.html(tpl)
        }
    </script>
@endpush
