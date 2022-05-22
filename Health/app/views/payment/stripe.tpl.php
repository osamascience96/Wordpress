<?php echo $header; ?>
<div class="layer-stretch">
	<div class="layer-wrapper">
		<div class="panel panel-default mb-0">
			<div class="panel-head">
				<div class="panel-title text-center">
					<span class="panel-title-text">Card Details</span>
				</div>
			</div>
			<div class="panel-body">
				<div class="cell example example3" id="example-3">
					<form action="<?php echo URL.DIR_ROUTE.'invoice/stripe'; ?>" method="post" id="payment-form">
						<input type="hidden" id="stripeToken" class="stripeToken" name="stripeToken" value="tok_1FrpD9CfC2MKrgIpsUtVyE4l">
						<div class="fieldset">
							<div id="example3-card-number" class="field empty mb-3"></div>
							<div id="example3-card-expiry" class="field empty third-width"></div>
							<div id="example3-card-cvc" class="field empty third-width"></div>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-primary btn-pill" data-tid="elements_examples.form.pay_button">Pay Now</button>
						</div>
						<div class="error" role="alert">
							<span class="message"></span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	
	.example .error {
		display: -ms-flexbox;
		display: flex;
		-ms-flex-pack: center;
		justify-content: center;
		position: absolute;
		width: 100%;
		bottom: 0;
		left: 0;
		color: #333;
		padding: 0 15px;
		font-size: 13px !important;
		opacity: 0;
		transform: translateY(10px);
		transition-property: opacity, transform;
		transition-duration: 0.35s;
		transition-timing-function: cubic-bezier(0.165, 0.84, 0.44, 1);
	}

	.example .error.visible {
		opacity: 1;
		transform: none;
	}

	.example .error .message {
		font-size: inherit;
	}

	
	.example.example3 {
		max-width: 400px;
		width: 100%;
		margin: 0 auto;
		/*background-color: #525f7f;*/
	}

	.example.example3 * {
		font-family: Dosis, Open Sans, Segoe UI, sans-serif;
		font-size: 16px;
		font-weight: 600;
	}

	.example.example3 .fieldset {
		margin: 0 15px 30px;
		padding: 0;
		border-style: none;
		display: -ms-flexbox;
		display: flex;
		-ms-flex-flow: row wrap;
		flex-flow: row wrap;
		-ms-flex-pack: justify;
		justify-content: space-between;
	}

	.example.example3 .field {
		padding: 16px 20px 16px;
		background-color: #f5f9fc;
		width: 100%;
		border-radius: 40px;
	}

	.example.example3 .field.half-width {
		width: calc(50% - (5px / 2));
	}

	.example.example3 .field.third-width {
		width: calc(48% - (5px / 3));
	}

	.example.example3 .field + .field {
		margin-top: 6px;
	}

	.example.example3 .field.focus,
	.example.example3 .field:focus {
		color: #424770;
		background-color: #f6f9fc;
	}

	.example.example3 .field.invalid {
		background-color: #fa755a;
	}

	.example.example3 .field.invalid.focus {
		background-color: #f6f9fc;
	}

	.example.example3 .field.focus::-webkit-input-placeholder,
	.example.example3 .field:focus::-webkit-input-placeholder {
		color: #cfd7df;
	}

	.example.example3 .field.focus::-moz-placeholder,
	.example.example3 .field:focus::-moz-placeholder {
		color: #cfd7df;
	}

	.example.example3 .field.focus:-ms-input-placeholder,
	.example.example3 .field:focus:-ms-input-placeholder {
		color: #cfd7df;
	}

	.example.example3 input, .example.example3 button {
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		outline: none;
		border-style: none;
	}

	.example.example3 input {
		color: #fff;
	}

	.example.example3 input::-webkit-input-placeholder {
		color: #9bacc8;
	}

	.example.example3 input::-moz-placeholder {
		color: #9bacc8;
	}

	.example.example3 input:-ms-input-placeholder {
		color: #9bacc8;
	}

	.example.example3 button {
		
	}

	.example.example3 button:active {
		background-color: #f5be58;
	}

	.example.example3 .error svg .base {
		fill: #fa755a;
	}

	.example.example3 .error svg .glyph {
		fill: #fff;
	}

	.example.example3 .error .message {
		color: #fff;
	}

	.example.example3 .success .icon .border {
		stroke: #fcd669;
	}

	.example.example3 .success .icon .checkmark {
		stroke: #fff;
	}

	.example.example3 .success .title {
		color: #fff;
	}

	.example.example3 .success .message {
		color: #9cabc8;
	}

	.example.example3 .success .reset path {
		fill: #fff;
	}

	.ElementsApp, .ElementsApp .InputElement {
		color: inherit;
	}
</style>
<?php echo $footer; ?>