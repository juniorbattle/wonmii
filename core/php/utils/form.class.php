<?php

class FORM
{
  public $start       = null;
  public $end         = null;
  public $content     = null;
  public $action      = null;
  public $method      = null;
  public $name        = null;
  public $target      = null;
  public $display     = null;

  function __construct($action,$name,$method='POST',$target=null)
  {
      $this->action = $action;
      $this->name   = $name;
      $this->method = $method;
      $this->target = $target;
      $this->start  = '<form id="' . $this->name . '" name="' . $this->name . '" action="' . $this->action . '" method="' . $this->method . '" target="' . $this->target . '">';
      $this->end    = '</form>';
  }

  private function initForm()
  {
    $this->display = null;
    $this->formDisplay();
  }

  private function formDisplay()
  {
    $this->display = $this->start;
    $this->display .= $this->content;
    $this->display .= $this->getButtons();
    $this->display .= $this->getConfirmationForm();
    $this->display .= $this->end;
  }

  public function getForm()
  {
    return $this->display;
  }

  public function formText($name,$label=null,$placeholder=false,$value=null,$disabled=null)
  {
    $this->content .= '<div class="form-group ' . $name . '-group">';
    if($label) {
      $this->content .= '<label class="libelle">' . $label . '</label>';
      if($placeholder) {
        $placeholder = $label;
      }
    }
    if($placeholder) $placeholder = $label;
    if($disabled) $disabled = 'disabled="disabled"';
    $this->content .= '<input type="text" id="' . $name . '" name="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '" ' . $disabled .' />';
    $this->content .= '</div>';
    $this->initForm();
  }

  public function formPassword($name,$label=null,$placeholder=false,$value=null,$disabled=null)
  {
    $this->content .= '<div class="form-group ' . $name . '-group">';
    if($label) {
      $this->content .= '<label class="libelle">' . $label . '</label>';
      if($placeholder) {
        $placeholder = $label;
      }
    }
    $this->content .= '<input type="password" id="' . $name . '" name="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '" ' . $disabled .' />';
    $this->content .= '</div>';
    $this->initForm();
  }

  public function formTextarea($name,$label=null,$placeholder=false,$value=null,$disabled=null)
  {
    $this->content .= '<div class="form-group ' . $name . '-group">';
    if($label) {
      $this->content .= '<label class="libelle">' . $label . '</label>';
      if($placeholder) {
        $placeholder = $label;
      }
    }
    $this->content .= '<textarea id="' . $name . '" name="' . $name . '" placeholder="' . $placeholder. '" ' . $disabled .'>' . $value . '</textarea>';
    $this->content .= '</div>';
    $this->initForm();
  }

  public function formSelect($name,$label=null,$values=array(),$selected=null,$disabled=null)
  {
    $content = null;
    $this->content .= '<div class="form-group ' . $name . '-group">';
    if($label) {
      $this->content .= '<label class="libelle">' . $label . '</label>';
    }
    foreach($values as $key => $value) {
      $selectedValue = null;
      if($selected == $key) $selectedValue = 'selected';
      $content .= '<option value="' . $key . '" selected="' . $selectedValue . '">' . $value . '</option>';
    }
    $this->content .= '<select id="' . $name . '" name="' . $name . '" ' . $disabled .'>' . $content . '</select>';
    $this->content .= '</div>';
    $this->initForm();
  }

  public function formCheckbox($name,$label=null,$values=array(),$checked=array())
  {
    $this->content .= '<div class="form-group ' . $name . '-group">';
    if($label) {
      $this->content .= '<label class="libelle">' . $label . '</label>';
    }
    foreach($values as $key => $value) {
      $checkedValue = null;
      if(in_array($key,$checked)) $checkedValue = 'checked="checked"';
      $this->content .= '<input type="checkbox" id="' . $name . '" name="' . $name . '" value="' . $key . '" ' . $checkedValue . '>' . $value . '';
    }
    $this->content .= '</div>';
    $this->initForm();
  }

  public function formRadio($name,$label=null,$values=array(),$checked=null)
  {
    $this->content .= '<div class="form-group ' . $name . '-group">';
    if($label) {
      $this->content .= '<label class="libelle">' . $label . '</label>';
    }
    foreach($values as $key => $value){
      $checkedValue = null;
      if($checked == $key) $checkedValue = 'checked';
      $this->content .= '<input type="radio" id="' . $name . '" name="' . $name . '" value="' . $key . '" checked="' . $checkedValue . '">' . $value . '';
    }
    $this->content .= '</div>';
    $this->initForm();
  }

  private function getConfirmationForm()
  {
    $display = '<div class="confirmationForm">Le formulaire a bien été envoyé.</div>';

    return $display;
  }

  private function getButtons()
  {
    $display = '<div class="validationForm">';
    $display .=  $this->submitForm();
    //$display .=  $this->resetForm();
    $display .= '</div>';

    return $display;
  }

  private function submitForm()
  {
    return $this->button = '<button class="btn-default btn-form" type="submit" name="validerForm">Valider</button>';
  }

  private function resetForm()
  {
    return $this->button = '<button type="reset" name="validerForm">Reset</button>';
  }

}
