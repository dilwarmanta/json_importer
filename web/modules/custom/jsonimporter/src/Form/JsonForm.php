<?php

namespace Drupal\jsonimporter\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;

class JsonForm extends ConfigFormBase
{

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'jsonimporter.jsonfile',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'jsonfile_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('jsonimporter.jsonfile');

    $form['json_pdf'] = [
      '#type' => 'textarea',
      '#title' => $this->t('PDF JSON'),
      '#description' => $this->t('Paste the JSON of your PDF here'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('jsonimporter.jsonfile')
      ->set('json_pdf', $form_state->getValue('json_pdf'))
      ->save();

    $pdf_json = $this->config('jsonimporter.jsonfile')->get('json_pdf');

    if (empty($pdf_json)) {
      $this->messenger->addMessage('There isn\'t a json there m8');
    }
    else {
      $this->createPdfNode($pdf_json);
    }
  }

  /**
   * Create nodes from JSON.
   */
  protected function createPdfNode(string $json) {
    $jsonout = json_decode($json, TRUE);

    foreach ($jsonout as $pdf_json) {
//      // Create multiple new paragraphs
//      $multiParagraph1 = Paragraph::create([
//        'type' => 'paragraph_machine_name',
//        'field_machine_name' => 'Field value',
//      ]);
//      $multiParagraph2 = Paragraph::create([
//        'type' => 'paragraph_machine_name',
//        'field_machine_name' => 'Field value',
//      ]);
//      $multiParagraph1->save();
//      $multiParagraph2->save();
//      $i = 1;
      foreach ($pdf_json['chapters'] as $chapter) {
//        dd($chapter);die;
        $paragraph
      }
      $paras = [];
      foreach($paragraphs as $para) {
        dd($para->id());
        $paras = [
          'target_id' => $para->id(),
          'target_revision_id' => $para->getRevisionId(),
        ];
      }
      dd($paras);die;
      $node = Node::create(array(
        'type' => 'pdf_node',
        'langcode' => 'en',
        'uid' => '1',
        'status' => 1,
        'title' => $pdf_json['Title'],
        'field_pdf_body' => [
          'value' => $pdf_json['PDF body'],
          'format' => 'full_html',
        ],
      ));

      $node->save();
    }
  }

}
