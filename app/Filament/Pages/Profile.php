<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class Profile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'My Profile';
    protected static ?string $title = 'Profile Settings';
    protected static ?string $slug = 'profile';
    protected static bool $shouldRegisterNavigation = true;
    protected static ?int $navigationSort = 99;
    
    protected static string $view = 'filament.pages.profile';
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->data = [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ];
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profile Information')
                    ->description('Update your account\'s profile information.')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('avatar')
                            ->image()
                            ->directory('avatars')
                            ->visibility('public')
                            ->imageEditor(),
                    ]),
                
                Section::make('Security')
                    ->description('Ensure your account is using a long, random password to stay secure.')
                    ->schema([
                        TextInput::make('current_password')
                            ->password()
                            ->label('Current Password')
                            ->dehydrated(false)
                            ->rules(['required_with:password']),
                        TextInput::make('password')
                            ->password()
                            ->label('New Password')
                            ->dehydrated(false)
                            ->rules(['confirmed']),
                        TextInput::make('password_confirmation')
                            ->password()
                            ->label('Confirm Password')
                            ->dehydrated(false)
                            ->rules(['required_with:password']),
                    ]),
            ])
            ->statePath('data');
    }
    
    public function submit(): void
    {
        $data = $this->form->getState();
        
        $user = Auth::user();
        
        if (isset($data['password']) && $data['password']) {
            if (!Hash::check($data['current_password'], $user->password)) {
                Notification::make()
                    ->title('Current password is incorrect')
                    ->danger()
                    ->send();
                
                return;
            }
            
            $user->password = Hash::make($data['password']);
        }
        
        $user->name = $data['name'];
        $user->email = $data['email'];
        
        // Handle avatar upload
        if (isset($data['avatar']) && $data['avatar']) {
            // If it's a new upload, it will be a temporary path
            if (is_string($data['avatar']) && str_starts_with($data['avatar'], 'livewire-file:')) {
                // The file will be moved automatically by Filament
                $user->avatar = $data['avatar'];
            }
        }
        
        $user->save();
        
        Notification::make()
            ->title('Profile updated successfully')
            ->success()
            ->send();
    }
} 