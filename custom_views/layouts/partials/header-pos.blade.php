<!-- default value -->
@php
    $go_back_url = action([\App\Http\Controllers\SellPosController::class, 'index']);
    $transaction_sub_type = '';
    $view_suspended_sell_url = action([\App\Http\Controllers\SellController::class, 'index']).'?suspended=1';
    $pos_redirect_url = action([\App\Http\Controllers\SellPosController::class, 'create']);
    $theme_divider_class = 'theme_' . $business_details->theme_color . '_divider';
	  $theme_pos_class = 'theme_' . $business_details->theme_color . '_pos';
@endphp

@if(!empty($pos_module_data))
    @foreach($pos_module_data as $key => $value)
        @php
            if(!empty($value['go_back_url'])) {
                $go_back_url = $value['go_back_url'];
            }

            if(!empty($value['transaction_sub_type'])) {
                $transaction_sub_type = $value['transaction_sub_type'];
                $view_suspended_sell_url .= '&transaction_sub_type='.$transaction_sub_type;
                $pos_redirect_url .= '?sub_type='.$transaction_sub_type;
            }
        @endphp
    @endforeach
@endif
<input type="hidden" name="transaction_sub_type" id="transaction_sub_type" value="{{$transaction_sub_type}}">
@inject('request', 'Illuminate\Http\Request')
<div class="col-md-12 no-print pos-header">
  <input type="hidden" id="pos_redirect_url" value="{{$pos_redirect_url}}">
  <div class="row {{$theme_pos_class}}" > <!-- #JCN Color to the header --> 
    <div class="col-md-6">
      <div class="m-6 mt-5" style="display: flex; color: #fff">
        <p ><strong >@lang('sale.location'): &nbsp;</strong> 
          @if(empty($transaction->location_id))
            @if(count($business_locations) > 1)
            <div style="width: 28%;margin-bottom: 5px;">
               {!! Form::select('select_location_id', $business_locations, $default_location->id ?? null , ['class' => 'form-control input-sm',
                'id' => 'select_location_id', 
                'required', 'autofocus'], $bl_attributes); !!}
            </div>
            @else
              {{$default_location->name}}
            @endif
          @endif

          @if(!empty($transaction->location_id)) {{$transaction->location->name}} @endif &nbsp;
            &nbsp;&nbsp; {{--add space--}}
            <span class="curr_datetime" >{{ @format_datetime('now') }}</span> 
            &nbsp;&nbsp; {{-- add space--}}
            {{--#JCN Remove <i text-muted --}}
            <i class="fa fa-keyboard hover-q" aria-hidden="true" data-container="body" data-toggle="popover" data-placement="bottom" data-content="@include('sale_pos.partials.keyboard_shortcuts_details')" data-html="true" data-trigger="hover" data-original-title="" title=""></i>

            
        </p>
      </div>
    </div>
    <div class="col-md-6">
      <a href="{{$go_back_url}}" title="{{ __('lang_v1.go_back') }}" class="btn btn-info btn-flat m-6 btn-xs m-5 pull-right">
        <strong><i class="fa fa-backward fa-lg"></i></strong>
      </a>
      @if(!empty($pos_settings['inline_service_staff']))
        <button type="button" id="show_service_staff_availability" title="{{ __('lang_v1.service_staff_availability') }}" class="btn btn-primary btn-flat m-6 btn-xs m-5 pull-right" data-container=".view_modal" 
          data-href="{{ action([\App\Http\Controllers\SellPosController::class, 'showServiceStaffAvailibility'])}}">
            <strong><i class="fa fa-users fa-lg"></i></strong>
        </button>
      @endif

      @can('close_cash_register')
      <button type="button" id="close_register" title="{{ __('cash_register.close_register') }}" class="btn btn-danger btn-flat m-6 btn-xs m-5 btn-modal pull-right" data-container=".close_register_modal" 
          data-href="{{ action([\App\Http\Controllers\CashRegisterController::class, 'getCloseRegister'])}}">
            <strong><i class="fa fa-window-close fa-lg"></i></strong>
      </button>
      @endcan
      
      @can('view_cash_register')
      <button type="button" id="register_details" title="{{ __('cash_register.register_details') }}" class="btn btn-success btn-flat m-6 btn-xs m-5 btn-modal pull-right" data-container=".register_details_modal" 
          data-href="{{ action([\App\Http\Controllers\CashRegisterController::class, 'getRegisterDetails'])}}">
            <strong><i class="fa fa-briefcase fa-lg" aria-hidden="true"></i></strong>
      </button>
      @endcan

      <button title="@lang('lang_v1.calculator')" id="btnCalculator" type="button" class="btn btn-success btn-flat pull-right m-5 btn-xs mt-10 popover-default" data-toggle="popover" data-trigger="click" data-content='@include("layouts.partials.calculator")' data-html="true" data-placement="bottom">
            <strong><i class="fa fa-calculator fa-lg" aria-hidden="true"></i></strong>
      </button>

      <button type="button" class="btn btn-danger btn-flat m-6 btn-xs m-5 pull-right popover-default" id="return_sale" title="@lang('lang_v1.sell_return')" data-toggle="popover" data-trigger="click" data-content='<div class="m-8"><input type="text" class="form-control" placeholder="@lang("sale.invoice_no")" id="send_for_sell_return_invoice_no"></div><div class="w-100 text-center"><button type="button" class="btn btn-danger" id="send_for_sell_return">@lang("lang_v1.send")</button></div>' data-html="true" data-placement="bottom">
            <strong><i class="fas fa-undo fa-lg"></i></strong>
      </button>

      <button type="button" title="{{ __('lang_v1.full_screen') }}"
          class="btn btn-primary btn-flat m-6 hidden-xs btn-xs m-5 pull-right" id="full_screen">
          <strong><i class="fas fa-expand-arrows-alt"></i></strong>
        </button>
        {{-- #king added second screen here changed the icons for full screen and second screen --}}
        <button type="button" title="second screen" class="btn btn-secondary btn-flat m-6 btn-xs m-5 pull-right"
          id="second_screen" onclick="openCustomerPOSView()">
          <strong><i class="fa fa-window-maximize fa-lg"></i></strong>
        </button>

      <button type="button" id="view_suspended_sales" title="{{ __('lang_v1.view_suspended_sales') }}" class="btn bg-yellow btn-flat m-6 btn-xs m-5 btn-modal pull-right" data-container=".view_modal" 
          data-href="{{$view_suspended_sell_url}}">
            <strong><i class="fa fa-pause-circle fa-lg"></i></strong>
      </button>
      @if(empty($pos_settings['hide_product_suggestion']) && isMobile())
        <button type="button" title="{{ __('lang_v1.view_products') }}"   
          data-placement="bottom" class="btn btn-success btn-flat m-6 btn-xs m-5 btn-modal pull-right" data-toggle="modal" data-target="#mobile_product_suggestion_modal">
            <strong><i class="fa fa-cubes fa-lg"></i></strong>
        </button>
      @endif

      @if(Module::has('Repair') && $transaction_sub_type != 'repair')
        @include('repair::layouts.partials.pos_header')
      @endif

        @if(in_array('pos_sale', $enabled_modules) && !empty($transaction_sub_type))
          @can('sell.create')
            <a href="{{action([\App\Http\Controllers\SellPosController::class, 'create'])}}" title="@lang('sale.pos_sale')" class="btn btn-success btn-flat m-6 btn-xs m-5 pull-right">
              <strong><i class="fa fa-th-large"></i> &nbsp; @lang('sale.pos_sale')</strong>
            </a>
          @endcan
        @endif
        @can('expense.add')
        <button type="button" title="{{ __('expense.add_expense') }}"   
          data-placement="bottom" class="btn bg-purple btn-flat m-6 btn-xs m-5 btn-modal pull-right" id="add_expense">
            <strong><i class="fa fas fa-minus-circle"></i> @lang('expense.add_expense')</strong>
        </button>
        @endcan
        
        <!-- To show the name of the seller -->
        <div class="m-6 mt-5" style="display: flex; color: #fff">
          <!-- The user image in the navbar-->
          @php
            $profile_photo = auth()->user()->media;
          @endphp
          @if(!empty($profile_photo))
            <img src="{{$profile_photo->display_url}}" width="25px" height="25px" alt="User Image">
          @endif
          <p ><strong >&nbsp;</strong> 
            <span style="color: #fff;">{{ Auth::User()->first_name }} {{ Auth::User()->last_name }}</span>
          </p>
        </div>
        
    </div>
    
  </div>
</div>

{{-- #king screen resoltion settings here --}}
<script>
  function openCustomerPOSView() {
// URL of customer-side POS view.
var customerPOSURL = "{{ route('customer.pos.view') }}";

// Detect the number of screens (monitors) available.
var numberOfScreens = window.screen.availWidth > window.innerWidth ? 2 : 1;

// Define default window dimensions.
var windowWidth = 800;
var windowHeight = 600;

if (numberOfScreens > 1) {
// If there is a second screen (extended display), use the second screen for the customer view.

var width = window.screen.availWidth;
var height = window.screen.availHeight;

customerPOSWindow = window.open(
customerPOSURL,
'Customer POS',
'left=0,top=0,width=' + width + ',height=' + height
);
} else {
// Open on the current screen with default dimensions if second screen not detected
customerPOSWindow = window.open(customerPOSURL, 'Customer POS', 'width=' + windowWidth + ', height=' + windowHeight);
}


}

</script>