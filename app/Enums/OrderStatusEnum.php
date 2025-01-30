<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderStatusEnum: string implements HasLabel, HasColor, HasIcon
{
    case Unpaid = 'unpaid';         // Order dibuat, pembayaran belum dilakukan
    case Pending = 'pending';       // Pembayaran sedang diverifikasi (contoh: transfer bank)
    case Paid = 'paid';             // Pembayaran dikonfirmasi lunas
    case Processing = 'processing'; // Sedang diproses (otomatis/manual)
    case Completed = 'completed';   // Produk berhasil dikirim
    case Failed = 'failed';         // Gagal mengirim produk (perlu tindakan manual)
    case OnHold = 'on_hold';        // Ditahan sementara (contoh: kecurigaan fraud)
    case Cancelled = 'cancelled';   // Transaksi dibatalkan
    case Refunded = 'refunded';     // Dana dikembalikan ke pembeli

    public function getLabel(): string
    {
        return match ($this) {
            self::Unpaid => 'Belum Bayar',
            self::Pending => 'Verifikasi Pembayaran',
            self::Paid => 'Terkonfirmasi',
            self::Processing => 'Sedang Diproses',
            self::Completed => 'Selesai',
            self::Failed => 'Gagal',
            self::OnHold => 'Ditahan',
            self::Cancelled => 'Dibatalkan',
            self::Refunded => 'Direfund',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Unpaid => 'gray',
            self::Pending => 'yellow',
            self::Paid => 'green',
            self::Processing => 'blue',
            self::Completed => 'purple',
            self::Failed => 'red',
            self::OnHold => 'orange',
            self::Cancelled => 'red',
            self::Refunded => 'pink',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Unpaid => 'heroicon-o-x-circle',
            self::Pending => 'heroicon-o-clock',
            self::Paid => 'heroicon-o-currency-dollar',
            self::Processing => 'heroicon-o-cog-6-tooth',
            self::Completed => 'heroicon-o-check-badge',
            self::Failed => 'heroicon-o-exclamation-triangle',
            self::OnHold => 'heroicon-o-pause-circle',
            self::Cancelled => 'heroicon-o-no-symbol',
            self::Refunded => 'heroicon-o-arrow-uturn-left',
        };
    }
}
