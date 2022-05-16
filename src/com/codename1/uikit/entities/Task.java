/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.codename1.uikit.entities;

import java.util.Date;
import java.util.Objects;

/**
 *
 * @author bhk
 */
public class Task {
    private int age,id;
    private String firstname,lastname,sexe,password,email ; 

    public Task(int age, int id, String firstname, String lastname, String sexe, String password, String email) {
        this.age = age;
        this.id = id;
        this.firstname = firstname;
        this.lastname = lastname;
        this.sexe = sexe;
        this.password = password;
        this.email = email;
    }

    public Task(int id, String firstname, String lastname, String sexe, String password, String email) {
        this.id = id;
        this.firstname = firstname;
        this.lastname = lastname;
        this.sexe = sexe;
        this.password = password;
        this.email = email;
    }

    public Task() {
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

 
    public int getAge() {
        return age;
    }

    public void setAge(int age) {
        this.age = age;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getFirstname() {
        return firstname;
    }

    public void setFirstname(String firstname) {
        this.firstname = firstname;
    }

    public String getLastname() {
        return lastname;
    }

    public void setLastname(String lastname) {
        this.lastname = lastname;
    }

    public String getSexe() {
        return sexe;
    }

    public void setSexe(String sexe) {
        this.sexe = sexe;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    @Override
    public int hashCode() {
        int hash = 7;
        hash = 97 * hash + this.age;
        hash = 97 * hash + this.id;
        hash = 97 * hash + Objects.hashCode(this.firstname);
        hash = 97 * hash + Objects.hashCode(this.lastname);
        hash = 97 * hash + Objects.hashCode(this.sexe);
        hash = 97 * hash + Objects.hashCode(this.password);
        return hash;
    }

    @Override
    public boolean equals(Object obj) {
        if (this == obj) {
            return true;
        }
        if (obj == null) {
            return false;
        }
        if (getClass() != obj.getClass()) {
            return false;
        }
        final Task other = (Task) obj;
        if (this.age != other.age) {
            return false;
        }
        if (this.id != other.id) {
            return false;
        }
        if (!Objects.equals(this.firstname, other.firstname)) {
            return false;
        }
        if (!Objects.equals(this.lastname, other.lastname)) {
            return false;
        }
        if (!Objects.equals(this.sexe, other.sexe)) {
            return false;
        }
        if (!Objects.equals(this.password, other.password)) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "Task{" + "age=" + age + ", id=" + id + ", firstname=" + firstname + ", lastname=" + lastname + ", sexe=" + sexe + ", password=" + password + ", email=" + email + '}';
    }

   
    

    

  
    
}
