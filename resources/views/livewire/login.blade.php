<div class="d-flex flex-column flex-lg-row flex-column-fluid">
    <div class="d-flex flex-lg-row-fluid">
        <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100"> <img
                class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                src="assets/media/auth/agency.png" alt="" /> <img
                class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                src="assets/media/auth/agency-dark.png" alt="" />
            <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">Fast, Efficient and Productive</h1>
            <div class="text-gray-600 fs-base text-center fw-semibold">In this kind of post, <a href="#"
                    class="opacity-75-hover text-primary me-1">the blogger</a>introduces a person they’ve interviewed
                <br />and provides some background information about <a href="#"
                    class="opacity-75-hover text-primary me-1">the interviewee</a>and their <br />work following this is
                a transcript of the interview.
            </div>
        </div>
    </div>
    <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
        <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
            <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form"
                        data-kt-redirect-url="index.html" action="#">
                        <div class="text-center mb-11">
                            <h1 class="text-gray-900 fw-bolder mb-3">Attendance Management</h1>
                            {{-- <div class="text-gray-500 fw-semibold fs-6">Your Login</div> --}}
                        </div>
                        <div class="separator separator-content my-14"> <span
                                class="w-125px text-gray-500 fw-semibold fs-7">Login</span> </div>
                        <div class="fv-row mb-8">
                            <input type="text" placeholder="Mobile" name="mobile" autocomplete="off"
                                class="form-control bg-transparent" wire:model='mobile' />
                        </div>
                        @if ($isSent)
                            <div class="fv-row mb-3">
                                <input type="number" placeholder="Otp" name="otp" autocomplete="off"
                                    class="form-control bg-transparent" wire:model='otp' />
                            </div>
                        @endif

                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            {{-- <div></div> <a href="authentication/layouts/overlay/reset-password.html" class="link-primary">Forgot Password ?</a> --}}
                        </div>
                        <div class="d-grid mb-10">
                            <button type="button" class="btn btn-primary" wire:click='sendOtp'>
                                <span class="indicator-label">Sign In</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
