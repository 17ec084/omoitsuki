import numpy as np

class Auto_roter:
    """
    n次元ベクトルを各方向にdeg(※)だけ回転させるような回転行列を求める
    (要は各軸方向の単位ベクトルから、0な成分をなくしたい)
    ※ラジアンではなく弧度法で。45など。
    円周率の計算誤差のためにnpyファイルが必要以上に作られることを
    避けるための仕様だ。

    オプション:old_lady・・・逆回転(元に戻す)用の回転行列のnpyファイルも同時に生成
    老婆心ながらの機能なのでこう名付けた。
    """
    def __init__(self, n, deg, old_lady=True):
        path = str(n)+"dim_"+str(deg)+".npy"
        theta = (deg/180)*np.pi
        try:
            self.mat = np.load(path)
        except IOError:
            rot_mat = np.identity(n)

            #回転平面(=2つの軸)を選ぶ
            for i in range(n):
                for j in range(i+1, n):

                    #回転平面xixjに沿って回転させる行列を逐次左にかけていく
                    rot_mat_ij = _Simple_roter(n, i, j, theta).get_mat()
                    rot_mat = np.dot(rot_mat, rot_mat_ij)

            self.mat = np.copy(rot_mat)

            #npyファイルに結果を保存
            np.save(path, self.mat)
            if old_lady: Auto_deroter(n, deg)

    def get_mat_list(self):
        return self.mat.tolist()

    def get_mat_ndarray(self):
        return self.mat

    def get_dot_list(self, vec):
        return np.dot(self.mat, vec).tolist()

    def get_dot_ndarray(self, vec):
        return np.dot(self.mat, vec)

class Auto_deroter:
    """
    Auto_roterと真逆の手順。
    Auto_roterによる回転を元に戻すために使われる
    """
    def __init__(self, n, deg):
        path = str(n)+"dim_"+str(deg)+"_reverse.npy"
        theta = (deg/180)*np.pi
        try:
            self.mat = np.load(path)
        except IOError:
            rot_mat = np.identity(n)

            for i in range(n):
                for j in range(i+1, n):

                    #回転平面xixjに沿って「逆」回転させる行列を逐次「右」にかけていく
                    rot_mat_ij = _Simple_roter(n, i, j, -theta).get_mat()
                    rot_mat = np.dot(rot_mat_ij, rot_mat)

            self.mat = np.copy(rot_mat)

            np.save(path, self.mat)

    def get_mat(self):
        return self.mat
    

class _Simple_roter:
    def __init__(self, n, i, j, theta):
        eyes = np.identity(n)
        eyes[i,i] = np.cos(theta); eyes[i,j] =-np.sin(theta)
        eyes[j,i] = np.sin(theta); eyes[j,j] = np.cos(theta)
        self.mat = np.copy(eyes)

    def get_mat_list(self):
        return self.mat.tolist()

    def get_mat_ndarray(self):
        return self.mat

    def get_dot_list(self, vec):
        return np.dot(self.mat, vec).tolist()

    def get_dot_ndarray(self, vec):
        return np.dot(self.mat, vec)                
