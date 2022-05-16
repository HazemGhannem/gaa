/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.codename1.uikit.pheonixui;

import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.uikit.entities.Usedproduct;
import com.codename1.uikit.services.ServiceUsedproduct;

/**
 *
 * @author bhk
 */
public class AddUsedproductForm extends Form{

    public AddUsedproductForm(Form previous) {
        setTitle("Add a new Usedproduct");
        setLayout(BoxLayout.y());
       
        TextField tfName = new TextField("","Usedproduct Name");
         TextField tfimage = new TextField("","Usedproduct image");
          TextField tfdescription = new TextField("","Usedproduct description");
           TextField tfprix = new TextField("","Usedproduct prix");
            
        Button btnValider = new Button("Add Usedproduct");
        
        btnValider.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                if ((tfimage.getText().length()==0)&&(tfName.getText().length()==0)&&(tfdescription.getText().length()==0)&&(tfprix.getText().length()==0))
                    Dialog.show("Alert", "Please fill all the fields", new Command("OK"));
                else
                {
                    try {
                       
                        Usedproduct L = new Usedproduct(17,tfName.getText(),tfimage.getText(), tfdescription.getText(),Float.parseFloat(tfprix.getText()));
                                
                        if( ServiceUsedproduct.getInstance().addLivreur(L))
                        {
                            
                           Dialog.show("Success","Connection accepted",new Command("OK"));
                           sms.gaaloul("un produit a été ajouté");
                        }else
                            Dialog.show("ERROR", "Server error", new Command("OK"));
                    } catch (NumberFormatException e) {
                        Dialog.show("ERROR", "Status must be a number", new Command("OK"));
                    }
                    
                }
                
                
            }
        });
        
        addAll(tfprix,tfName,tfdescription,tfimage,btnValider);
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e-> previous.showBack());
                
    }
    
    
}
