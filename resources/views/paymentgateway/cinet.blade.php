{{ html()->form('POST', route('paymentsettingsUpdates'))->attribute('enctype', 'multipart/form-data')->attribute('data-toggle', 'validator')->open() }}
{{ html()->hidden('id',$payment_data->id ?? null)->attribute('placeholder', 'id')->class('form-control') }}
{{ html()->hidden('type', $tabpage)->attribute('placeholder', 'id')->class('form-control') }}
 <div class="row">
    <div class="form-group col-md-12" >
        <div class="form-control d-flex align-items-center justify-content-between">
            <label for="enable_cinet" class="mb-0">{{__('messages.payment_on',['gateway'=>__('messages.cinet')])}}</label>
            <div class="custom-control custom-switch custom-switch-text custom-switch-color custom-control-inline">
                <input type="checkbox" class="custom-control-input" name="status" id="enable_cinet" {{!empty($payment_data) && $payment_data->status == 1 ? 'checked' : ''}}>
                <label class="custom-control-label" for="enable_cinet"></label>
            </div>
        </div>
    </div>
 </div>
 <div class="row" id='enable_cinet_payment'>
    <div class="form-group col-md-12">
        <label class="form-control-label">{{__('messages.payment_option',['gateway'=>__('messages.cinet')])}}</label><br/>
        <div class="form-check-inline">
            <label class="form-check-label">
                <input type="radio" class="form-check-input is_test" value="on" name="is_test" data-type="is_test_mode" {{!empty($payment_data) && $payment_data->is_test == 1 ? 'checked' :''}}>{{__('messages.is_test_mode')}}
            </label>
        </div>
        <div class="form-check-inline">
            <label class="form-check-label">
                <input type="radio" class="form-check-input is_test" value="off" name="is_test" data-type="is_live_mode" {{!empty($payment_data) && $payment_data->is_test == 0 ? 'checked' :''}}>{{__('messages.is_live_mode')}}
            </label>
        </div>
        <small class="help-block with-errors text-danger"></small>
    </div>
    <div class="form-group col-md-12">
        {{ html()->label(trans('messages.gateway_name') . ' <span class="text-danger">*</span>', 'title', ['class' => 'form-control-label']) }}
        {{ html()->text('title', old('title'))->id('title')->placeholder(trans('messages.title'))->class('form-control')}}
        <small class="help-block with-errors text-danger"></small>
    </div>
    <div class="form-group col-md-12">
        {{ html()->label(trans('messages.cinet_id') . ' <span class="text-danger">*</span>', 'cinet_id', ['class' => 'form-control-label']) }}
        {{ html()->text('cinet_id', old('cinet_id'))->id('cinet_id')->placeholder(trans('messages.cinet_id'))->class('form-control')}}
        <small class="help-block with-errors text-danger"></small>
    </div>
    <div class="form-group col-md-12">
        {{ html()->label(trans('messages.cinet_key') . ' <span class="text-danger">*</span>', 'cinet_key', ['class' => 'form-control-label']) }}
        {{ html()->text('cinet_key', old('cinet_key'))->id('cinet_key')->placeholder(trans('messages.cinet_key'))->class('form-control')}}
        <small class="help-block with-errors text-danger"></small>
    </div>
    <div class="form-group col-md-12">
        {{ html()->label(trans('messages.cinet_publickey') . ' <span class="text-danger">*</span>', 'cinet_publickey', ['class' => 'form-control-label']) }}
        {{ html()->text('cinet_publickey', old('cinet_publickey'))->id('cinet_publickey')->placeholder(trans('messages.cinet_publickey'))->class('form-control')}}
        <small class="help-block with-errors text-danger"></small>
    </div>
        </div>
        {{ html()->submit(__('messages.save'))->class('btn btn-md btn-primary float-md-end') }}
        {{ html()->form()->close() }}
<script>
var enable_cinet = $("input[name='status']").prop('checked');
checkPaymentTabOption(enable_cinet);

$('#enable_cinet').change(function(){
    value = $(this).prop('checked') == true ? true : false;
    checkPaymentTabOption(value);
});
function checkPaymentTabOption(value){
    if(value == true){
        $('#enable_cinet_payment').removeClass('d-none');
        $('#title').prop('required', true);
        $('#cinet_id').prop('required', true);
        $('#cinet_key').prop('required', true);
        $('#cinet_publickey').prop('required', true);
    }else{
        $('#enable_cinet_payment').addClass('d-none');
        $('#title').prop('required', false);
        $('#cinet_id').prop('required', false);
        $('#cinet_key').prop('required', false);
        $('#cinet_publickey').prop('required', false);
    }
}

var get_value = $('input[name="is_test"]:checked').data("type");
getConfig(get_value)
$('.is_test').change(function(){
    value = $(this).prop('checked') == true ? true : false;
    type = $(this).data("type");
    getConfig(type)

});

function getConfig(type){
    var _token   = $('meta[name="csrf-token"]').attr('content');
    var baseUrl = $('meta[name="baseUrl"]').attr('content');
    var page =  "{{$tabpage}}";
    $.ajax({
        url: baseUrl+"/get_payment_config",
        type:"POST",
        data:{
          type:type,
          page:page,
          _token: _token
        },
        success:function(response){
            var obj = '';
            var cinet_id=cinet_key=cinet_publickey=title = '';

            if(response){
            
                if(response.data.type == 'is_test_mode'){
                    obj = JSON.parse(response.data.value);
                }else{
                    obj = JSON.parse(response.data.live_value);
                }

                if(response.data.title != ''){
                    title = response.data.title
                }
                
                if(obj !== null){
                    var cinet_id = obj.cinet_id;
                    var cinet_key = obj.cinet_key;
                    var cinet_publickey = obj.cinet_publickey;
                }

                $('#cinet_id').val(cinet_id)
                $('#cinet_key').val(cinet_key)
                $('#cinet_publickey').val(cinet_publickey)
                $('#title').val(title)
            
            }
        },
        error: function(error) {
         console.log(error);
        }
    });
}

</script>