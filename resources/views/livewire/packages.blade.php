<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-2 pt-lg-10">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
            <!--begin::Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Packages
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Pages</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Pricing</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">

                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Pricing card-->
            <div class="card mb-10" id="kt_pricing">
                <!--begin::Card body-->
                <div class="card-body p-lg-17">
                    <!--begin::Plans-->
                    <div class="d-flex flex-column">
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <h1 class="fs-2hx fw-bold mb-5">Choose Your Plan</h1>
                            <div class="text-gray-600 fw-semibold fs-5"></div>
                            <select class="form-select form-select-solid" data-control="select2"
                                data-placeholder="Seller Annual Fee" data-hide-search="true"
                                data-select2-id="select2-data-7-0fji" tabindex="-1" aria-hidden="true"
                                data-kt-initialized="1" wire:model='otherPersonRechargeId'>
                                <option value="">--Self--</option>
                                @foreach ($referals as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Nav group-->
                        <div class="nav-group nav-group-outline mx-auto mb-15" data-kt-buttons="true"
                            data-kt-initialized="1">
                            <button class="btn btn-color-gray-600 btn-active btn-active-secondary px-6 py-3 me-2 active"
                                data-kt-plan="month">Monthly</button>
                            {{-- <button class="btn btn-color-gray-600 btn-active btn-active-secondary px-6 py-3" data-kt-plan="annual">Annual</button> --}}
                        </div>
                        <!--end::Nav group-->
                        <!--begin::Row-->
                        <div class="row g-10">
                            <!--begin::Col-->
                            @foreach ($packages as $key => $value)
                                <div class="col-xl-3">
                                    <div class="d-flex h-100 align-items-center">
                                        <!--begin::Option-->
                                        <div
                                            class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                            <!--begin::Heading-->
                                            <div class="mb-7 text-center">
                                                <!--begin::Title-->
                                                <h1 class="text-gray-900 mb-5 fw-bolder">
                                                    {{ $value->package_name ?? '' }}</h1>
                                                <!--end::Title-->
                                                <!--begin::Description-->
                                                <div class="text-gray-600 fw-semibold mb-5">Optimal for
                                                    {{ $value->min_staff ?? '' }} - {{ $value->max_staff ?? '' }} team
                                                    size
                                                    <br>and new startup
                                                </div>
                                                <!--end::Description-->
                                                <!--begin::Price-->
                                                <div class="text-center">
                                                    <span class="mb-2 text-primary">Rs</span>
                                                    <span class="fs-3x fw-bold text-primary"
                                                        data-kt-plan-price-month="39"
                                                        data-kt-plan-price-annual="399">{{ $value->amount ?? '' }}</span>
                                                    <span class="fs-7 fw-semibold opacity-50">/
                                                        <span data-kt-element="period">Mon</span></span>
                                                </div>
                                                <!--end::Price-->
                                            </div>
                                            <!--end::Heading-->
                                            <!--begin::Features-->
                                            <div class="w-100 mb-10">
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-5">
                                                    <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Up to
                                                        {{ $value['member'] }}
                                                        Active Users</span>
                                                    <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-5">
                                                    <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Up to
                                                        In out report</span>
                                                    <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-5">
                                                    <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Daily
                                                        whatsapp report</span>
                                                    <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                                </div>
                                                <div class="d-flex align-items-center mb-5">
                                                    <span
                                                        class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Location
                                                        Based Authentication</span>
                                                    <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                                </div>
                                                <div class="d-flex align-items-center mb-5">
                                                    <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Selfie
                                                        Verfication</span>
                                                    <i class="ki-outline ki-check-circle fs-1 text-success"></i>
                                                </div>

                                            </div>
                                            <!--end::Features-->
                                            <!--begin::Select-->
                                            <a wire:click="recharge('{{ encrypt($value->id) }}')"
                                                class="btn btn-sm btn-primary">Select</a>
                                            <!--end::Select-->
                                        </div>
                                        <!--end::Option-->
                                    </div>
                                </div>
                            @endforeach


                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Plans-->
                </div>
                <!--end::Card body-->
            </div>
            <div class="card">
                <!--begin::Header-->
                <div class="card-header card-header-stretch">
                    <!--begin::Title-->
                    <div class="card-title">
                        <h3 class="m-0 text-gray-800">Recharge History</h3>
                    </div>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar m-0">
                        <!--begin::Tab nav-->
                        <ul class="nav nav-stretch fs-5 fw-semibold nav-line-tabs border-transparent" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a id="kt_referrals_year_tab" class="nav-link text-active-gray-800 active"
                                    data-bs-toggle="tab" role="tab" href="#kt_referrals_1" aria-selected="true">This
                                    Year</a>
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
                    <div id="kt_referrals_1" class="card-body p-5 tab-pane fade show active" role="tabpanel"
                        aria-labelledby="kt_referrals_year_tab">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered table-row-solid gy-4 gs-9">
                                <!--begin::Thead-->
                                <thead class="border-gray-200 fs-5 fw-semibold bg-lighten">
                                    <tr>
                                        <th class="min-w-125px">Package Name</th>
                                        <th class="min-w-125px">Amount</th>
                                        <th class="min-w-125px">Recharge for</th>
                                        <th class="min-w-125px">Recharge by</th>
                                        <th class="min-w-125px">Date</th>
                                        <th class="min-w-125px">Tranasaction Id</th>
                                    </tr>
                                </thead>
                                <!--end::Thead-->
                                <!--begin::Tbody-->
                                <tbody class="fs-6 fw-semibold text-gray-600">
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->package->package_name ?? '' }}</td>
                                            <td>{{ $item->unit_price ?? '' }}</td>
                                            <td>{{ $item->buyer_name ?? '' }}</td>
                                            <td>{{ $item->rechargeBy->name ?? '' }}</td>
                                            <td>
                                                {{ $item->created_at->format('d-m-Y') ?? '' }}
                                            </td>
                                            <td>{{ $item->payment_id }}</td>
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
            <!--end::Pricing card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
