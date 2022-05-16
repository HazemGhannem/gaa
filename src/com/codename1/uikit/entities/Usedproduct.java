/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.codename1.uikit.entities;

import java.util.Date;

/**
 *
 * @author hp
 */
public class Usedproduct {
    private int id,idCategory;
    private String name,image,description;
    private float prix;

    public Usedproduct(int id, int idCategory, String name, String image, String description, float prix) {
        this.id = id;
        this.idCategory = idCategory;
        this.name = name;
        this.image = image;
        this.description = description;
        this.prix = prix;
    }

    public Usedproduct() {
    }

    public Usedproduct(int idCategory, String name, String image, String description, float prix) {
        this.idCategory = idCategory;
        this.name = name;
        this.image = image;
        this.description = description;
        this.prix = prix;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getIdCategory() {
        return idCategory;
    }

    public void setIdCategory(int idCategory) {
        this.idCategory = idCategory;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getImage() {
        return image;
    }

    public void setImage(String image) {
        this.image = image;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public float getPrix() {
        return prix;
    }

    public void setPrix(float prix) {
        this.prix = prix;
    }

    @Override
    public String toString() {
        return "Usedproduct{" + "id=" + id + ", idCategory=" + idCategory + ", name=" + name + ", image=" + image + ", description=" + description + ", prix=" + prix + '}';
    }
 
  
}
