<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\DeepLTranslationService;
use App\Models\Post;

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
            
            if (!$model) {
                session()->flash('error', 'Model not found');
                return;
            }

            // Translate attributes
            $this->translatedData = $model->translateAttributes(
                strtoupper($this->targetLanguage),
                $this->sourceLanguage ? strtoupper($this->sourceLanguage) : null
            );

            session()->flash('success', 'Translation completed successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Translation failed: ' . $e->getMessage());
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

            session()->flash('success', 'Translation saved successfully!');
            $this->translatedData = [];
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save: ' . $e->getMessage());
        }
    }

    protected function getModel()
    {
        if (!$this->modelType || !$this->modelId) {
            return null;
        }

        $class = "App\\Models\\" . $this->modelType;
        
        if (!class_exists($class)) {
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
            'usage' => $usage
        ]);
    }
}