package com.app.barcodeattendance;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.makeramen.roundedimageview.RoundedTransformationBuilder;
import com.squareup.picasso.Picasso;
import com.squareup.picasso.Transformation;

import org.json.JSONException;
import org.json.JSONObject;

public class Dashboard extends Fragment {

    SharedPreferences sharedPreferences;
    ImageView image;
    public String response;
    public TextView fname,level,email,dept,matric,phone,gender;

    public Func func;

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View root = inflater.inflate(R.layout.dashboard, container, false);

        sharedPreferences = getActivity().getSharedPreferences("ALL_USER_INFO", Context.MODE_PRIVATE);
        response = sharedPreferences.getString("all_user_info", null);

        getActivity().setTitle("Student Dashboard");
        func = new Func(getActivity());

        fname = root.findViewById(R.id.fname);
        dept = root.findViewById(R.id.dept);
        phone = root.findViewById(R.id.phone);
        email = root.findViewById(R.id.email);
        level = root.findViewById(R.id.level);
        gender = root.findViewById(R.id.gender);
        image = root.findViewById(R.id.profile_image);
        matric = root.findViewById(R.id.parent_id);

        try {

            JSONObject object = new JSONObject(response);
            JSONObject student_info = object.getJSONObject("student_info");

            matric.setText(student_info.getString("matric"));
            fname.setText(student_info.getString("fname"));
            phone.setText(student_info.getString("phone"));
            level.setText(student_info.getString("level"));
            gender.setText(student_info.getString("gender"));
            email.setText(student_info.getString("email"));
            dept.setText(student_info.getString("dept"));

            Transformation transformation = new RoundedTransformationBuilder()
                .cornerRadiusDp(50)
                .oval(true)
                .build();

            final String matric = student_info.getString("matric").toLowerCase();
            Picasso.get().load(Core.IMG_URL+matric+".jpg").transform(transformation).into(image);

        }catch (JSONException e){
            e.printStackTrace();;
        }

        return root;
    }
}
