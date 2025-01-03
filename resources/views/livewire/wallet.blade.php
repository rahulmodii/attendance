<div>
    <div class="row g-xxl-9">
        <!--begin::Col-->
        <div class="col-xxl-8">
            <!--begin::Earnings-->
            <div class="card card-xxl-stretch mb-5 mb-xxl-10">
                <!--begin::Header-->
                <div class="card-header">
                    <div class="card-title">
                        <h3>Earnings</h3>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pb-0">
                    <span class="fs-5 fw-semibold text-gray-600 pb-5 d-block">Last 30 day earnings calculated. Apart from
                        arranging the order of topics.</span>
                    <!--begin::Left Section-->
                    <div class="d-flex flex-wrap justify-content-between pb-6">
                        <!--begin::Row-->
                        <div class="d-flex flex-wrap">
                            <!--begin::Col-->
                            <div class="border border-dashed border-gray-300 w-125px rounded my-3 p-4 me-6">
                                <span class="fs-2x fw-bold text-gray-800 lh-1">
                                    <span data-kt-countup="true" data-kt-countup-value="6,840"
                                        data-kt-countup-prefix="$" class="counted" data-kt-initialized="1">Rs
                                        {{ auth()->user()->wallet_balance }}</span>
                                </span>
                                <span class="fs-6 fw-semibold text-gray-500 d-block lh-1 pt-2">Current Balance</span>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="border border-dashed border-gray-300 w-125px rounded my-3 p-4 me-6">
                                <span class="fs-2x fw-bold text-gray-800 lh-1">
                                    <span class="counted" data-kt-countup="true" data-kt-countup-value="80"
                                        data-kt-initialized="1">{{ $totalRefered ?? '' }}</span></span>
                                <span class="fs-6 fw-semibold text-gray-500 d-block lh-1 pt-2">Total Refered</span>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="border border-dashed border-gray-300 w-125px rounded my-3 p-4 me-6">
                                <span class="fs-2x fw-bold text-gray-800 lh-1">
                                    <span data-kt-countup="true" data-kt-countup-value="1,240"
                                        data-kt-countup-prefix="$" class="counted" data-kt-initialized="1">$1,240</span>
                                </span>
                                <span class="fs-6 fw-semibold text-gray-500 d-block lh-1 pt-2">Fees</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <a href="#" class="btn btn-primary px-6 flex-shrink-0 align-self-center">Withdraw
                            Earnings</a>
                    </div>
                    <!--end::Left Section-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Earnings-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xxl-4">
            <!--begin::Invoices-->
            <div class="card card-xxl-stretch mb-5 mb-xxl-10">
                <!--begin::Header-->
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="text-gray-800">Coupons</h3>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    <span class="fs-5 fw-semibold text-gray-600 pb-6 d-block">Download apart from order of the good
                        awesome invoice topics</span>
                    <!--begin::Left Section-->
                    <div class="d-flex align-self-center">
                        <div class="flex-grow-1 me-3">
                            <!--begin::Select-->
                            {{-- <select class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-placeholder="Seller Annual Fee" data-hide-search="true" data-select2-id="select2-data-7-0fji" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                                <option value="" data-select2-id="select2-data-9-zeee"></option>
                                <option value="1">Individual Seller Account</option>
                                <option value="2">Variable Closing Fee</option>
                                <option value="3">Minimum Referral Fee</option>
                            </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-8-jqmw" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-7zbh-container" aria-controls="select2-7zbh-container"><span class="select2-selection__rendered" id="select2-7zbh-container" role="textbox" aria-readonly="true" title="Seller Annual Fee"><span class="select2-selection__placeholder">Seller Annual Fee</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span> --}}
                            <input type="text" wire:model='coupon' class="form-control form-select-solid" />
                            <!--end::Select-->
                        </div>
                        <!--begin::Action-->
                        <button type="button" class="btn btn-primary btn-icon flex-shrink-0" wire:click='applyCoupon'>
                            <i class="ki-outline ki-arrow-down fs-1"></i>
                        </button>
                        <!--end::Action-->
                    </div>
                    <!--end::Left Section-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Invoices-->
        </div>
        <!--end::Col-->
    </div>
    <div class="card">
        <!--begin::Header-->
        <div class="card-header card-header-stretch">
            <!--begin::Title-->
            <div class="card-title">
                <h3 class="m-0 text-gray-800">Account Statement</h3>
            </div>
            <!--end::Title-->
            <!--begin::Toolbar-->
            <div class="card-toolbar m-0">
                <!--begin::Tab nav-->
                <ul class="nav nav-stretch fs-5 fw-semibold nav-line-tabs border-transparent" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_year_tab" class="nav-link text-active-gray-800 active" data-bs-toggle="tab"
                            role="tab" href="#kt_referrals_1" aria-selected="true">This Year</a>
                    </li>
                </ul>
                <!--end::Tab nav-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Header-->
        <!--begin::Tab Content-->
        <div id="kt_referred_users_tab_content" class="tab-content">
            <!--begin::Tab panel-->
            <div id="kt_referrals_1" class="card-body p-0 tab-pane fade show active" role="tabpanel"
                aria-labelledby="kt_referrals_year_tab">
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-bordered table-row-solid gy-4 gs-9">
                        <!--begin::Thead-->
                        <thead class="border-gray-200 fs-5 fw-semibold bg-lighten">
                            <tr>
                                <th class="min-w-175px ps-9">Type</th>
                                <th class="min-w-150px px-0">Amount</th>
                                <th class="min-w-125">Coupon Name</th>
                                <th class="min-w-125px">Coupon Used By name</th>
                                <th class="min-w-125px text-center">Tranasaction Type</th>
                                <th class="min-w-125px text-center">Date</th>
                            </tr>
                        </thead>
                        <!--end::Thead-->
                        <!--begin::Tbody-->
                        <tbody class="fs-6 fw-semibold text-gray-600">
                            @foreach ($data as $item)
                                <tr>
                                    <td class="ps-9">{{ $item->account_source ? 'Referal' : '' }}</td>
                                    <td class="ps-0 text-success">+{{ $item->amount ?? '' }}</td>
                                    <td>{{ $item->coupon_used_string ?? '' }}</td>
                                    <td class="text-center">{{ $item->used_by_name ?? '' }}</td>
                                    <td class="text-center">
                                        {{ $item->type ? 'Credit' : 'Debit' }}
                                    </td>
                                    <td class="text-center">{{ $item->created_at->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                        <!--end::Tbody-->
                    </table>
                    <!--end::Table-->
                </div>
            </div>
            <!--end::Tab panel-->
            <!--begin::Tab panel-->


            <!--end::Tab panel-->
        </div>
        <!--end::Tab Content-->
    </div>
</div>
