<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img class="mx-auto h-40 w-auto" src={{asset("storage/logo.jpg")}} alt="SH & ML S.RL">
        <h3 class="mt-2 text-center text-xl font-bold tracking-tight text-white">BIENVENIDO</h3>
        <h2 class="text-center text-3xl font-bold tracking-tight text-white">SH & ML S.R.L.</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6 flex flex-col gap-4" wire:submit.prevent="submit">
            <div class="flex flex-col gap-y-2">
                <label for="email" class="text-sm/6 font-medium text-white">E-mail</label>
                <div class="relative">
                    <input type="text" wire:model.defer="email" name="email" id="email" autocomplete="email" class="block w-full rounded-md bg-zinc-900 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-zinc-300 placeholder:text-zinc-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-600 sm:text-sm/6">
                    @error('email')
                        <p class="absolute -bottom-6 text-red-700 text-sm/tight">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col gap-y-2">
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm/6 font-medium text-white">Contraseña</label>
                    <div class="text-sm">
                        <a href={{route("recover-password")}} class="font-semibold text-yellow-600 hover:text-yellow-500">Olvidaste la contraseña?</a>
                    </div>
                </div>
                <div class="relative">
                    <input type="password" wire:model.defer="password" name="password" id="password" autocomplete="current-password" class="block w-full rounded-md bg-zinc-900 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-zinc-300 placeholder:text-zinc-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-600 sm:text-sm/6">
                    @error('password')
                    <p class="absolute -bottom-6 text-red-700 text-sm/tight">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <button type="submit" class="flex w-full justify-center rounded-md bg-yellow-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-yellow-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-600 hover:cursor-pointer">Ingresar</button>
            </div>
        </form>

    </div>
</div>
