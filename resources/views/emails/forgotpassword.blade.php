@component('mail::message')
# Olá {{ $user->name }},

<p>Você requisitou a alteração de senha da sua conta {{ config('app.name') }}. Por favor, clique no link abaixo para redefinir a sua senha.</p>
<p>O link de recuperação tem 1 hora de validade.</p>

@component('mail::button', ['url' => $resetPasswordLink])
Redefinir senha
@endcomponent

<p>Ou, simplesmente copie e cole o link abaixo em seu navegador:</p>
<p>{{ $resetPasswordLink }}</p>
<p style="font-size: 12px">Por favor, ignore este email se você não requisitou alteração de senha.</p>
@endcomponent
