<div class="flex flex-wrap gap-4 bg-white p-6 rounded-2xl justify-between">
    <div class="w-[48%]">
        <p>Name</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="full_name"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->full_name : old('full_name') }}" @error('full_name') is-invalid @enderror">
        @error('full_name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="w-[48%]">
        <p>Email</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="email"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->email : old('email') }}">
        @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="w-[48%]">
        <p>Phone Number</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="mobile"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->mobile : old('mobile') }}">
        @error('mobile')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="w-[48%]">
        <p>Address</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="address"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->address : old('address') }}">

    </div>
    @error('address')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
    <div class="w-[48%]">
        <p>Country</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="country"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->country : old('country') }}">
        @error('country')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>
    <div class="w-[48%]">
        <p>State/Region</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="region"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->region : old('region') }}">
        @error('region')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="w-[48%]">
        <p>City</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="city"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->city : old('city') }}">
        @error('city')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="w-[48%]">
        <p>Zip/Code</p>
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="code"
               placeholder="" value="{{ (!empty($user) and empty($new_user)) ? $user->code : old('code') }}">
        @error('code')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="w-full">
        <p>About</p>
        <textarea class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8"  name="about"
                  placeholder="">{!! (!empty($user) and empty($new_user)) ? $user->about : old('about')  !!}</textarea>
        @error('about')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="flex justify-end w-full">
        <button type="submit" class="rounded-xl px-5 py-1.5 bg-primary.main text-white">
        <span class="font-medium text-sm">
            Save Changes
        </span>
        </button>
    </div>
</div>
