<?php

namespace App\Services;

use App\Enums\ParticipantRole;
use App\Models\Conversation;

class ConversationService
{
    public function __construct(protected Conversation $model) {}

    public function fetchConversations(?string $search = null, ?array $filters = null)
    {
        $baseQuery = $this->model
            // ✅ Conversation must include authenticated user
            ->whereHas('participants', function ($query) {
                $query->where('participant_id', user()->id)
                    ->whereIn('participant_role', [
                        ParticipantRole::BUYER->value,
                        ParticipantRole::SELLER->value,
                    ])
                    ->where('is_active', true);
            })

            // ✅ Load ONLY the OTHER participant (not me)
            ->with(['participants' => function ($query) {
                $query->where('participant_id', '!=', user()->id)
                    ->whereIn('participant_role', [
                        ParticipantRole::BUYER->value,
                        ParticipantRole::SELLER->value,
                    ])
                    ->where('is_active', true)
                    ->with('participant');
            }]);

        // 🔍 Search on OTHER participant name
        if ($search) {
            $baseQuery->whereHas('participants', function ($participantQuery) use ($search) {
                $participantQuery
                    ->where('participant_id', '!=', user()->id)
                    ->whereIn('participant_role', [
                        ParticipantRole::BUYER->value,
                        ParticipantRole::SELLER->value,
                    ])
                    ->whereHasMorph(
                        'participant',
                        [\App\Models\User::class],
                        function ($userQuery) use ($search) {
                            $userQuery->where(function ($q) use ($search) {
                                $q->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%")
                                    ->orWhereRaw(
                                        "CONCAT(first_name, ' ', last_name) LIKE ?",
                                        ["%{$search}%"]
                                    );
                            });
                        }
                    );
            });
        }

        return $baseQuery
            ->orderByDesc('last_message_at')
            ->get();
    }
}
