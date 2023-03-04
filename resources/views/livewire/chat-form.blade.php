<div>
    {{-- Be like water. --}}
    
    {{--<div class="form-group">
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" class="form-control" wire:model="name">
        @error('name') <small class="text-danger">{{$message}}</small> @enderror
    </div>--}}
    
    {{--<input type="text" value="{{$phone_id}}" >--}}
    {{--<input type="text" name="trading_user_id" id="trading_user_id" class="form-control" wire:model="trading_user_id">--}}
    <div class="form-group mb-2">
        {{--<label for="name">Mensagem</label>--}}
        <textarea name="message" id="message" cols="10" rows="2" class="form-control" placeholder="Escreva aqui!" wire:model="message"></textarea>
        @error('message') <small class="text-danger">{{$message}}</small> @enderror
    </div>
    <button class="btn btn-primary" wire:click="sendMessage">Enviar</button>
    <div style="position: absolute">
        <div class="alert alert-success collapse mt-3"
            role="alert" id="alertSuccess"
        >
        Mensagem enviada!
        </div>
    </div>
    <script>
        window.livewire.on("messageSent", function name(params) {
            $("#alertSuccess").fadeIn("slow");

            setTimeout(() => {
                $("#alertSuccess").fadeOut("slow")
            }, 3000);
        })
    </script>
</div>
