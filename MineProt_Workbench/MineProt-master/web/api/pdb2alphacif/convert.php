<?php
$TMP_DIR = sys_get_temp_dir() . '/' . md5($PDB);
shell_exec("mkdir $TMP_DIR");
$PDB_File_Path = "$TMP_DIR/$PROTEIN_NAME.pdb";
$PDB_File = fopen($PDB_File_Path, 'w');
fwrite($PDB_File, $PDB);
fclose($PDB_File);

$CIF_File_Path = "$TMP_DIR/$PROTEIN_NAME.cif";
putenv("RCSBROOT=" . getenv("RCSBROOT"));
putenv("PATH=" . getenv("PATH"));
shell_exec("maxit -input $PDB_File_Path -output $CIF_File_Path -o 1");
$CIF = file_get_contents($CIF_File_Path);
echo $CIF;
echo "loop_\n";
echo "_ma_qa_metric_local.label_asym_id\n";
echo "_ma_qa_metric_local.label_comp_id\n";
echo "_ma_qa_metric_local.label_seq_id\n";
echo "_ma_qa_metric_local.metric_id\n";
echo "_ma_qa_metric_local.metric_value\n";
echo "_ma_qa_metric_local.model_id\n";
echo "_ma_qa_metric_local.ordinal_id\n";
echo "#\n";
echo shell_exec("grep ATOM $PDB_File_Path | cut -c 18-21,23-26,61-66 | awk '{print \"A \"$1\" \"$2\" 2 \"$3\" 1 1\" }' | uniq");
echo "#";

shell_exec("rm -rf $TMP_DIR");
