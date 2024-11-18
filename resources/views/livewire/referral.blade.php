<div>
    <div class="card mb-5 mb-xl-10">
        <!--begin::Body-->
        <div class="card-body py-10">
            <h2 class="mb-9">Referral Program</h2>
            <!--begin::Overview-->
            <div class="row mb-10">
                <!--begin::Col-->
                <div class="col-xl-6 mb-15 mb-xl-0 pe-5">
                    <h4 class="mb-0">How to use Referral Program</h4>
                    <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">Use images to enhance your post, improve its flow, add humor
                    <br>and explain complex topics</p>
                    <a href="#" class="btn btn-light btn-active-light-primary fw-bold">Get Started</a>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xl-6">
                    <h4 class="text-gray-800 mb-0">Your Referral Link</h4>
                    <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">Plan your blog post by choosing a topic, creating an outline conduct
                    <br>research, and checking facts</p>
                    <div class="d-flex">
                        <input id="kt_referral_link_input" type="text" class="form-control form-control-solid me-3 flex-grow-1" name="search" value="{{ url('?referal=' . auth()->user()->country_code . '#' . auth()->user()->mobile) }}"
                        >
                        <button id="kt_referral_program_link_copy_btn" class="btn btn-light btn-active-light-primary fw-bold flex-shrink-0" data-clipboard-target="#kt_referral_link_input">Copy Link</button>
                    </div>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Overview-->
            <!--begin::Stats-->

            <!--end::Stats-->
            <!--begin::Info-->
            {{-- <p class="fs-5 fw-semibold text-gray-600 py-6">Writing headlines for blog posts is as much an art as it is a science, and probably warrants its own post, but for now, all I’d advise is experimenting with what works for your audience, especially if it’s not resonating with your audience</p> --}}
            <!--end::Info-->
            <!--begin::Notice-->
            {{-- <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                <!--begin::Icon-->
                <i class="ki-outline ki-bank fs-2tx text-primary me-4"></i>
                <!--end::Icon-->
                <!--begin::Wrapper-->
                <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                    <!--begin::Content-->
                    <div class="mb-3 mb-md-0 fw-semibold">
                        <h4 class="text-gray-900 fw-bold">Withdraw Your Money to a Bank Account</h4>
                        <div class="fs-6 text-gray-700 pe-7">Withdraw money securily to your bank account. Commision is $25 per transaction under $50,000</div>
                    </div>
                    <!--end::Content-->
                    <!--begin::Action-->
                    <a href="#" class="btn btn-primary px-6 align-self-center text-nowrap">Withdraw Money</a>
                    <!--end::Action-->
                </div>
                <!--end::Wrapper-->
            </div> --}}
            <!--end::Notice-->
        </div>
        <!--end::Body-->
    </div>
    <div class="card">
        <!--begin::Header-->
        <div class="card-header card-header-stretch">
            <!--begin::Title-->
            <div class="card-title">
                <h3>Referred Users</h3>
            </div>
            <!--end::Title-->
            <!--begin::Toolbar-->
            <div class="card-toolbar">
                <!--begin::Tab nav-->
                <ul class="nav nav-stretch fs-5 fw-semibold nav-line-tabs border-transparent" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_tab_1" class="nav-link text-active-gray-800 me-4 active" data-bs-toggle="tab" role="tab" href="#kt_referrals_1" aria-selected="true">1st level</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_tab_2" class="nav-link text-active-gray-800 me-4" data-bs-toggle="tab" role="tab" href="#kt_referrals_2" aria-selected="false" tabindex="-1">2nd level</a>
                    </li>
                    {{-- <li class="nav-item" role="presentation">
                        <a id="kt_referrals_tab_3" class="nav-link text-active-gray-800" data-bs-toggle="tab" role="tab" href="#kt_referrals_3" aria-selected="false" tabindex="-1">2021</a>
                    </li> --}}
                </ul>
                <!--end::Tab nav-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Header-->
        <!--begin::Tab content-->
        <div id="kt_referred_users_tab_content" class="tab-content">
            <!--begin::Tab panel-->
            <div id="kt_referrals_1" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_referrals_tab_1">
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-row-bordered align-middle gy-6">
                        <!--begin::Thead-->
                        <thead class="border-bottom border-gray-200 fs-6 fw-bold bg-lighten">
                            <tr>
                                {{-- <th class="min-w-125px ps-9">Order ID</th> --}}
                                <th class="min-w-125px  ps-9">User Name</th>
                                <th class="min-w-125px">Date</th>
                                <th class="min-w-125px">User Mobile</th>
                                {{-- <th class="min-w-125px ps-0">Profit</th> --}}
                            </tr>
                        </thead>
                        <!--end::Thead-->
                        <!--begin::Tbody-->
                        <tbody class="fs-6 fw-semibold text-gray-600">
                            @foreach ($data as $value)
                            <tr>
                                <td class="ps-9">{{ $value->name ?? '' }}</td>
                                <td class="ps-9">{{ $value->created_at->format('d-m-Y') }}</td>
                                <td class="ps-9">{{ $value->country_code  ?? ''}}{{ $value->mobile ?? '' }}</td>

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
            <div id="kt_referrals_2" class="card-body p-0 tab-pane fade" role="tabpanel" aria-labelledby="kt_referrals_tab_2">
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-row-bordered align-middle gy-6">
                        <!--begin::Thead-->
                        <thead class="border-bottom border-gray-200 fs-6 fw-bold bg-lighten">
                            <tr>
                                {{-- <th class="min-w-125px ps-9">Order ID</th> --}}
                                <th class="min-w-125px  ps-9">User Name</th>
                                <th class="min-w-125px">Date</th>
                                <th class="min-w-125px">User Mobile</th>
                                {{-- <th class="min-w-125px ps-0">Profit</th> --}}
                            </tr>
                        </thead>
                        <!--end::Thead-->
                        <!--begin::Tbody-->
                        <tbody class="fs-6 fw-semibold text-gray-600">
                            @foreach ($secondLevel as $value)
                            <tr>
                                <td class="ps-9">{{ $value->name ?? '' }}</td>
                                <td class="ps-9">{{ $value->created_at->format('d-m-Y') }}</td>
                                <td class="ps-9">{{ $value->country_code  ?? ''}}{{ $value->mobile ?? '' }}</td>

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
            <div id="kt_referrals_3" class="card-body p-0 tab-pane fade" role="tabpanel" aria-labelledby="kt_referrals_tab_3">
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-row-bordered align-middle gy-6">
                        <!--begin::Thead-->
                        <thead class="border-bottom border-gray-200 fs-6 fw-bold bg-lighten">
                            <tr>
                                {{-- <th class="min-w-125px ps-9">Order ID</th> --}}
                                <th class="min-w-125px px-0">User Name</th>
                                <th class="min-w-125px">Date</th>
                                <th class="min-w-125px">User Mobile</th>
                                {{-- <th class="min-w-125px ps-0">Profit</th> --}}
                            </tr>
                        </thead>
                        <!--end::Thead-->
                        <!--begin::Tbody-->
                        <tbody class="fs-6 fw-semibold text-gray-600">
                            @foreach ($data as $value)
                            <tr>
                                <td class="ps-9">{{ $value->name ?? '' }}</td>
                                <td class="ps-9">{{ $value->created_at->format('d-m-Y') }}</td>
                                <td class="ps-9">{{ $value->country_code  ?? ''}}{{ $value->mobile ?? '' }}</td>

                            </tr>
                            @endforeach


                        </tbody>
                        <!--end::Tbody-->
                    </table>
                    <!--end::Table-->
                </div>
            </div>
            <!--end::Tab panel-->
        </div>
        <!--end::Tab content-->
    </div>
</div>
