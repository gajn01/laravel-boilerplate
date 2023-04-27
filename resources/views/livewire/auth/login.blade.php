@section('title', 'Mary Grace Restaurant Operation System / Login')

<div class="d-flex justify-content-center align-items-center h-100">
    <div class="row">
        <div class="d-flex col-12 col-lg-6 justify-content-center">
            <img src="../asset/img/mg-store.png" class="img-fluid i" alt="">
        </div>
        <div class="col-12 col-lg-6">
            <h2 class="text-center mb-3">Sign-in</h2>
            <form wire:submit.prevent="onLogin">
                @csrf
                <div class="email mb-3">
                    <label class="sr-only fw-500" for="signin-email">Email <span class="text-danger">*</span></label>
                    <input id="signin-email" name="signin-email" type="email" wire:model.lazy="email"
                        class="form-control signin-email" placeholder="Email address">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="password mb-3">
                    <label class="sr-only fw-500" for="signin-password">Password <span class="text-danger">*</span></label>
                    <input id="signin-password" name="signin-password" type="password" wire:model.lazy="password"
                        class="form-control signin-password" placeholder="Password">
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="extra mt-3 row justify-content-between">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="RememberPassword">
                                <label class="form-check-label" for="RememberPassword"> Remember me </label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="forgot-password text-end">
                                <a href="#">Forgot password?</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn secondary-bg w-100 cta-color" wire:click="onLogin">Log In</button>
                </div>
            </form>
        </div>
    </div>
</div>
