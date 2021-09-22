<style type="text/css">
    input,
    .StripeElement {
        height: 40px;
        padding: 10px 12px;

        color: #32325d;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 4px;

        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    input:focus,
    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }

    .card-errors {
        color: #fefde5;
    }

    .info {
        grid-area: info;
        padding: 0 50px 0 0;
        border-right: 1px solid #6c757d;
    }

    .total {
        text-align: right;
    }

    .vico-color {
        color: #ea960f;
    }

    .paragraph {
        display: grid;
        grid-template: auto auto auto / 60% 40%;
        padding: 5px;
        font-weight: 300;
    }

    .values {
        text-align: right;
        padding-bottom: 20px;
    }

    .btn_document_type {
        width: 100px;
    }

    @media (max-width: 768px) {

        .info {
            border-right: 0;
            padding: 0;
        }

        .paragraph {
            padding: 0;
        }
    }
</style>