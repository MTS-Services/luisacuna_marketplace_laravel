<?php

namespace App\Livewire;

use App\Services\DeepLTranslationService;
use Livewire\Component;

class TranslationManager extends Component
{
    public $modelId;

    public $modelType;

    public $targetLanguage = '';

    public $sourceLanguage = null;

    public $translatedData = [];

    public $isTranslating = false;

    protected $rules = [
        'targetLanguage' => 'required|string|min:2|max:5',
    ];

    public function mount($modelId = null, $modelType = null)
    {
        $this->modelId = $modelId;
        $this->modelType = $modelType;
    }

    public function translate()
    {
        $this->validate();
        $this->isTranslating = true;

        try {
            $model = $this->getModel();

            if (! $model) {
                session()->flash('error', __('Model not found'));

                return;
            }

            // Translate attributes
            $this->translatedData = $model->translateAttributes(
                strtoupper($this->targetLanguage),
                $this->sourceLanguage ? strtoupper($this->sourceLanguage) : null
            );

            session()->flash('success', __('Translation completed successfully!'));
        } catch (\Exception $e) {
            session()->flash('error', __('Translation failed: :message', ['message' => $e->getMessage()]));
        } finally {
            $this->isTranslating = false;
        }
    }

    public function saveTranslation()
    {
        try {
            $model = $this->getModel();

            foreach ($this->translatedData as $key => $value) {
                $model->$key = $value;
            }

            $model->language = strtoupper($this->targetLanguage);
            $model->save();

            session()->flash('success', __('Translation saved successfully!'));
            $this->translatedData = [];
        } catch (\Exception $e) {
            session()->flash('error', __('Failed to save: :message', ['message' => $e->getMessage()]));
        }
    }

    protected function getModel()
    {
        if (! $this->modelType || ! $this->modelId) {
            return null;
        }

        $class = 'App\\Models\\'.$this->modelType;

        if (! class_exists($class)) {
            return null;
        }

        return $class::find($this->modelId);
    }

    public function render()
    {
        $translator = app(DeepLTranslationService::class);
        $targetLanguages = $translator->getTargetLanguages();
        $usage = $translator->getUsage();

        return view('livewire.translation-manager', [
            'targetLanguages' => $targetLanguages,
            'usage' => $usage,
        ]);
    }
}
