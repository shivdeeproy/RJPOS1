<table align="center" style="border-spacing: {{$barcode_details->col_distance * 1}}in {{$barcode_details->row_distance * 1}}in; overflow: hidden !important;">
@foreach($page_products as $page_product)

	@if($loop->index % $barcode_details->stickers_in_one_row == 0)
		<!-- create a new row -->
		<tr>
		<!-- <columns column-count="{{$barcode_details->stickers_in_one_row}}" column-gap="{{$barcode_details->col_distance*1}}"> -->
	@endif
		<td align="center" valign="center">
			<div style="overflow: hidden !important;display: flex; flex-wrap: wrap;width: {{$barcode_details->width * 1}}in; height: {{$barcode_details->height * 1}}in; justify-content: center;">

				<div style="width:100%; padding:2px;text-align: center;">
				

				<img style="width:100%;max-width:166px; !important;height: {{$barcode_details->height*0.24}}in !important; display: block;" src="data:image/png;base64,{{DNS1D::getBarcodePNG($page_product->sub_sku, $page_product->barcode_type, 1,30, array(0, 0, 0), false)}}">
					
					<span style="font-size: 10px !important">

						{{$page_product->lot_number?$page_product->lot_number.'/':''}}
						{{$page_product->sub_sku}}
					</span>
					<div class="" style="display:flex;">

				<div style="width:90%;text-align: left;display: flex;justify-content: space-between;flex-wrap: wrap;">

					<div style="width:65%;">

					@if(!empty($print['name']))
						<span style="display: block !important; font-size: {{$print['name_size']}}px">
							{{$page_product->product_actual_name}}

								</span>

									<span style="font-size:5px;">

							@if(isset($page_product->category_name))
							
									{{$page_product->category_name}}
							
							@endif
					
					

							@if(isset($page_product->category_name) && isset($page_product->sub_category_name) && $page_product->category_name && $page_product->sub_category_name)
							
									/

							@endif



							@if(isset($page_product->sub_category_name))
							
									{{$page_product->sub_category_name}}
							
							@endif
						</span>
					@endif
				</div>

				<div style="width:35%;display: block;">

					<span style="display: block !important; font-size:5px;margin-top:8px">

						<?php

						$price_code='';

						 $purchase_price = round($page_product->default_purchase_price_inc_tax);

                        $digit_code_array = [
                            '0' => 'O',
                            '1' => 'K',
                            '2' => 'D',
                            '3' => 'U',
                            '4' => 'G',
                            '5' => 'M',
                            '6' => 'B',
                            '7' => 'S',
                            '8' => 'L',
                            '9' => 'V'
                        ];

                        for ($i=0; $i < strlen($purchase_price); $i++) { 
                            $price_code .= $digit_code_array[((string)$purchase_price)[$i]];
                        }

						 ?>

					{{$price_code}}
						

								</span>

				</div>

				<div style="display:block; width: 100%;">	

				<!--second block-->

				<div style="display:flex; width: 100%;justify-content: space-between;">

					<div style="width:35%;display: flex;word-break:break-word;font-size: 5px;padding:2px;align-items: center;">
						<span>{{$page_product->product_custom_field1??''}}&nbsp;</span></div>

					<div style="width:65%;font-weight: bold;display: flex;justify-content: space-between;align-items: center;"><span style="font-size:10px">MRP.</span> 
					<div style="font-size:13px;width:70%;">₹ <span style="text-decoration:@if(isset($print['show_sale_price']))line-through; @endif font-size:16px;">{{round($page_product->mrp_inc_tax)}}</span></div></div>

				</div>


				<!--end -->

					<!--third block-->

				<div style="display:flex; width: 100%;justify-content: space-between;">

					<div style="width:35%;display: flex;word-break:break-word;font-size: 7px;padding:2px;align-items: center;flex-wrap: wrap;">
						<span style="font-weight:bold;display: block;">Size</span><div style="width:100%">{{$page_product->product_custom_field2??''}}</div></div>

						@if(isset($print['show_sale_price']))

					<div style="width:65%;font-weight: bold;display: flex;align-items: center;justify-content: space-between;"><span style="font-size:10px">Sale</span> 
					<div style="font-size:13px;width:70%;">₹ <span style="font-size:16px;">{{round($page_product->sell_price_inc_tax)}}</span></div></div>
					@endif

				</div>

				<!--end -->

			</div>

			

				</div>
				<div style="width:8%;text-align: left;margin-top:-7px;">
					<img style="max-width:12px;margin-bottom:2px;padding-left:0.5px" src="{{asset('img/receipt_logo.png')}}">
					<div style="font-size:6px;text-align: center;">
					<?php $name= str_split('RoyalJyoti') ;
					   foreach($name as $character):
					?>
					<span style="display:inline-block;margin-bottom: 2px;">{{$character}}</span><br>

				<?php endforeach;?>

				</div>
				</div>



				
				

			</div>


				<div style="display:block;font-size: 5px;text-align: right; width: 95%;font-weight: bold;">

Incl. of all taxes.
					
				</div>




			</div>


		</div>
		
		</td>

	@if($loop->iteration % $barcode_details->stickers_in_one_row == 0)
		</tr>
	@endif
@endforeach
</table>

<style type="text/css">

	td{
		border: 1px dotted lightgray;
	}
	@media print{
		
		table{
			page-break-after: always;
		}

		
		@page {
		size: {{$paper_width}}in {{$paper_height}}in;

		/*width: {{$barcode_details->paper_width}}in !important;*/
		/*height:@if($barcode_details->paper_height != 0){{$barcode_details->paper_height}}in !important @else auto @endif;*/
		margin-top: {{$margin_top}}in !important;
		margin-bottom: {{$margin_top}}in !important;
		margin-left: {{$margin_left}}in !important;
		margin-right: {{$margin_left}}in !important;
	}
	}
</style>