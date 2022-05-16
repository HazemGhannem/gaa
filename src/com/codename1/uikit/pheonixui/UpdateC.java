/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.codename1.uikit.pheonixui;

import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.uikit.entities.Category;
import com.codename1.uikit.services.ServiceCategory;

/**
 *
 * @author hp
 */
public class UpdateC extends Form {
       Form current;

   public UpdateC(Category p , Form previous) {
        setTitle("edit Category");
        setLayout(BoxLayout.y());
        TextField tfId = new TextField(String.valueOf(p.getId()), "id");
        TextField tfName = new TextField(p.getName(), "name");
     
       
        Button btnValider = new Button("edit Category");
        Button btnRet = new Button("Return");
        btnRet.addActionListener(e-> new HomeForm().show() );

        btnValider.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                   if ((tfName.getText().length()==0)) {
                    Dialog.show("Alert", "Please fill all the fields", new Command("OK"));
                } else {
                    try {
                        Category p = new Category(Integer.parseInt(tfId.getText()),tfName.getText());
                        System.out.println("---------");
                        
                        if (ServiceCategory.getInstance().modifierProduct(p)) {
                            Dialog.show("Success", "Connection accepted", new Command("OK"));
                        } else {
                            Dialog.show("ERROR", "Server error", new Command("OK"));
                        }
                    } catch (NumberFormatException e) {
                        Dialog.show("ERROR", "Status must be a number", new Command("OK"));
                    }

                }

            }

            
        });
        

        addAll(tfId,tfName, btnValider,btnRet);
        // getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> this.previous.showBack());

    }
    
    
}
