package com.app.barcodeattendance;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class Attendance extends Fragment {

    public List<Lists> mData = new ArrayList<>();
    public RecyclerView recyclerView;
    public RecyclerViewAdapters recyclerViewAdapters;
    SharedPreferences sharedPreferences;
    public String response;

    public Func func;

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View root = inflater.inflate(R.layout.attendance, container, false);

        getActivity().setTitle("Lists Attendance Course ");


        recyclerView = (RecyclerView) root.findViewById(R.id.my_recycler_view);
        recyclerViewAdapters = new RecyclerViewAdapters(mData);
        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(getActivity());
        recyclerView.setLayoutManager(layoutManager);
        recyclerView.setAdapter(recyclerViewAdapters);


        return  root;
    }

    @Override
    public void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        mData = new ArrayList<>();

        SharedPreferences sharedPreferences = getActivity().getSharedPreferences("attendance", Context.MODE_PRIVATE);
        response = sharedPreferences.getString("attendance",null);

        String id,title,code,name;

        try {

            JSONObject object = new JSONObject(response);
            JSONArray data = object.getJSONArray("attendance");

            for (int i =0; i < data.length(); i++){
                JSONObject attendance_data = data.getJSONObject(i);

                id = attendance_data.getString("id");
                name = attendance_data.getString("fname");
                title = attendance_data.getString("title");
                code = attendance_data.getString("code");

                mData.add(new Lists(title+" ("+code+") ","Lecturer in-Charge : "+name,"",Core.URI+"/templates/images/logo.png",id,""));

            }

        }catch (JSONException e){
            e.printStackTrace();
        }

    }
}
