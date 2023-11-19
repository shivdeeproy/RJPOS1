<br>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table bg-gray">
				<tr class="bg-green">

					<th colspan="2" class="text-center">@lang('product.default_mrp_price')</th>

					@can('view_purchase_price')
						<th colspan="2" class="text-center">@lang('product.default_purchase_price')</th>
					
					@endcan
					@can('access_default_selling_price')
						@can('view_purchase_price')
				        	<th>@lang('product.profit_percent')</th>
				        	  <th>@lang('product.discount')</th>
				        @endcan
				        <th colspan="2">@lang('product.default_selling_price')</th>
				       
				    @endcan
				  
				    @if(!empty($allowed_group_prices))
			        	<th>@lang('lang_v1.group_prices')</th>
			        @endif
			        <th>@lang('lang_v1.variation_images')</th>
				</tr>
				<tr>
					<th>(@lang('product.exc_of_tax'))</th>
						<th> (@lang('product.inc_of_tax'))</th>
						@can('view_purchase_price')
						<th>(@lang('product.exc_of_tax'))</th>
						<th> (@lang('product.inc_of_tax'))</th>
					@endcan

					@can('access_default_selling_price')
						<th></th>
					<th></th>
				       <th>(@lang('product.exc_of_tax'))</th>
						<th> (@lang('product.inc_of_tax'))</th>
				       
				    @endcan
				    @if(!empty($allowed_group_prices))
			        	<th></th>
			        @endif
					<th></th>
				
				</tr>
				@foreach($product->variations as $variation)
				<tr>
					<td>
						<span class="display_currency" data-currency_symbol="true">{{ $variation->mrp_exc_tax }}</span>
					</td>
					<td>
						<span class="display_currency" data-currency_symbol="true">{{ $variation->mrp_inc_tax }}</span>
					</td>
					@can('view_purchase_price')
					<td>
						<span class="display_currency" data-currency_symbol="true">{{ $variation->default_purchase_price }}</span>
					</td>
					<td>
						<span class="display_currency" data-currency_symbol="true">{{ $variation->dpp_inc_tax }}</span>
					</td>
					@endcan
					@can('access_default_selling_price')
						@can('view_purchase_price')
						<td>
							{{ @num_format($variation->profit_percent) }}
						</td>
						@endcan
						<td>
							{{ @num_format($variation->discount) }}
						</td>
						<td>
							<span class="display_currency" data-currency_symbol="true">{{ $variation->default_sell_price }}</span>
						</td>
						<td>
							<span class="display_currency" data-currency_symbol="true">{{ $variation->sell_price_inc_tax }}</span>
						</td>
					@endcan
					@if(!empty($allowed_group_prices))
			        	<td class="td-full-width">
			        		@foreach($allowed_group_prices as $key => $value)
			        			<strong>{{$value}}</strong> - @if(!empty($group_price_details[$variation->id][$key]))
			        				<span class="display_currency" data-currency_symbol="true">{{ $group_price_details[$variation->id][$key] }}</span>
			        			@else
			        				0
			        			@endif
			        			<br>
			        		@endforeach
			        	</td>
			        @endif
			        <td>
			        	@foreach($variation->media as $media)
			        		{!! $media->thumbnail([60, 60], 'img-thumbnail') !!}
			        	@endforeach
			        </td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>