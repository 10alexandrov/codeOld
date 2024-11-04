<div class="form-floating mb-3">   <!-- old -->
                                <input id="user" type="text" class="form-control @error('email') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                <label for="user">{{ __('User') }}</label>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
